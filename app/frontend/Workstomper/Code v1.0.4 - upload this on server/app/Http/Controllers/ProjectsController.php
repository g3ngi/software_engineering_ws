<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Status;
use App\Models\Project;
use App\Models\Workspace;
use App\Models\Milestone;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Models\ProjectClient;
use App\Services\DeletionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Exception;

class ProjectsController extends Controller
{
    protected $workspace;
    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // fetch session and use it in entire class with constructor
            $this->workspace = Workspace::find(session()->get('workspace_id'));
            $this->user = getAuthenticatedUser();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type = null)
    {
        $status = isset($_REQUEST['status']) && $_REQUEST['status'] !== '' ? $_REQUEST['status'] : "";
        $selectedTags = (request('tags')) ? request('tags') : [];
        $where = [];
        if ($status != '') {
            $where['status_id'] = $status;
        }
        $is_favorite = 0;
        if ($type === 'favorite') {
            $where['is_favorite'] = 1;
            $is_favorite = 1;
        }
        $sort = (request('sort')) ? request('sort') : "id";
        $order = 'desc';
        if ($sort == 'newest') {
            $sort = 'created_at';
            $order = 'desc';
        } elseif ($sort == 'oldest') {
            $sort = 'created_at';
            $order = 'asc';
        } elseif ($sort == 'recently-updated') {
            $sort = 'updated_at';
            $order = 'desc';
        } elseif ($sort == 'earliest-updated') {
            $sort = 'updated_at';
            $order = 'asc';
        }
        $projects = isAdminOrHasAllDataAccess() ? $this->workspace->projects() : $this->user->projects();
        $projects->where($where);
        if (!empty($selectedTags)) {
            $projects->whereHas('tags', function ($q) use ($selectedTags) {
                $q->whereIn('tags.id', $selectedTags);
            });
        }
        $projects = $projects->orderBy($sort, $order)->paginate(6);
        return view('projects.grid_view', ['projects' => $projects, 'auth_user' => $this->user, 'selectedTags' => $selectedTags, 'is_favorite' => $is_favorite]);
    }

    public function list_view(Request $request, $type = null)
    {
        $projects = isAdminOrHasAllDataAccess() ? $this->workspace->projects : $this->user->projects;
        $users = $this->workspace->users;
        $clients = $this->workspace->clients;
        $is_favorites = 0;
        if ($type === 'favorite') {
            $is_favorites = 1;
        }
        return view('projects.projects', ['projects' => $projects, 'users' => $users, 'clients' => $clients, 'is_favorites' => $is_favorites]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->workspace->users;
        $clients = $this->workspace->clients;

        return view('projects.create_project', ['users' => $users, 'clients' => $clients, 'auth_user' => $this->user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'status_id' => ['required'],
            'start_date' => ['required', 'before_or_equal:end_date'],
            'end_date' => ['required'],
            'budget' => ['nullable', 'regex:/^\d+(\.\d+)?$/'],
            'description' => ['required'],
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $formFields['start_date'] = format_date($start_date, null, "Y-m-d");
        $formFields['end_date'] = format_date($end_date, null, "Y-m-d");

        $formFields['workspace_id'] = $this->workspace->id;
        $formFields['created_by'] = $this->user->id;


        $new_project = Project::create($formFields);

        $userIds = $request->input('user_id') ?? [];
        $clientIds = $request->input('client_id') ?? [];
        $tagIds = $request->input('tag_ids') ?? [];
        // Set creator as a participant automatically
        if (Auth::guard('client')->check() && !in_array($this->user->id, $clientIds)) {
            array_splice($clientIds, 0, 0, $this->user->id);
        } else if (Auth::guard('web')->check() && !in_array($this->user->id, $userIds)) {
            array_splice($userIds, 0, 0, $this->user->id);
        }

        $project_id = $new_project->id;
        $project = Project::find($project_id);
        $project->users()->attach($userIds);
        $project->clients()->attach($clientIds);
        $project->tags()->attach($tagIds);

        Session::flash('message', 'Project created successfully.');
        return response()->json(['error' => false, 'id' => $new_project->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $project = Project::findOrFail($id);
        $tags = $project->tags;
        $users = $this->workspace->users;
        $clients = $this->workspace->clients;
        $types = getControllerNames();
        return view('projects.project_information', ['project' => $project, 'tags' => $tags, 'users' => $users, 'clients' => $clients, 'types' => $types, 'auth_user' => $this->user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $users = $this->workspace->users;
        $clients = $this->workspace->clients;
        return view('projects.update_project', ["project" => $project, "users" => $users, "clients" => $clients]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'status_id' => ['required'],
            'budget' => ['nullable', 'regex:/^\d+(\.\d+)?$/'],
            'start_date' => ['required', 'before_or_equal:end_date'],
            'end_date' => ['required'],
            'description' => ['required'],
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $formFields['start_date'] = format_date($start_date, null, "Y-m-d");
        $formFields['end_date'] = format_date($end_date, null, "Y-m-d");

        $userIds = $request->input('user_id') ?? [];
        $clientIds = $request->input('client_id') ?? [];
        $tagIds = $request->input('tag_ids') ?? [];
        $project = Project::findOrFail($id);
        // Set creator as a participant automatically
        if (User::where('id', $project->created_by)->exists() && !in_array($project->created_by, $userIds)) {
            array_splice($userIds, 0, 0, $project->created_by);
        } elseif (Client::where('id', $project->created_by)->exists() && !in_array($project->created_by, $clientIds)) {
            array_splice($clientIds, 0, 0, $project->created_by);
        }
        $project->update($formFields);
        $project->users()->sync($userIds);
        $project->clients()->sync($clientIds);
        $project->tags()->sync($tagIds);

        Session::flash('message', 'Project updated successfully.');
        return response()->json(['error' => false, 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $response = DeletionService::delete(Project::class, $id, 'Project');
        return $response;
    }

    public function destroy_multiple(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'ids' => 'required|array', // Ensure 'ids' is present and an array
            'ids.*' => 'integer|exists:projects,id' // Ensure each ID in 'ids' is an integer and exists in the 'projects' table
        ]);

        $ids = $validatedData['ids'];
        $deletedProjects = [];
        $deletedProjectTitles = [];
        // Perform deletion using validated IDs
        foreach ($ids as $id) {
            $project = Project::find($id);
            if ($project) {
                $deletedProjectTitles[] = $project->title;
                DeletionService::delete(Project::class, $id, 'Project');
                $deletedProjects[] = $id;
            }
        }

        return response()->json(['error' => false, 'message' => 'Project(s) deleted successfully.', 'id' => $deletedProjects, 'titles' => $deletedProjectTitles]);
    }



    public function list(Request $request, $id = '', $type = '')
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $status = isset($_REQUEST['status']) && $_REQUEST['status'] !== '' ? $_REQUEST['status'] : "";
        $user_id = (request('user_id')) ? request('user_id') : "";
        $client_id = (request('client_id')) ? request('client_id') : "";
        $start_date_from = (request('project_start_date_from')) ? request('project_start_date_from') : "";
        $start_date_to = (request('project_start_date_to')) ? request('project_start_date_to') : "";
        $end_date_from = (request('project_end_date_from')) ? request('project_end_date_from') : "";
        $end_date_to = (request('project_end_date_to')) ? request('project_end_date_to') : "";
        $is_favorites = (request('is_favorites')) ? request('is_favorites') : "";
        $where = [];
        if ($status != '') {
            $where['status_id'] = $status;
        }

        if ($is_favorites) {
            $where['is_favorite'] = 1;
        }

        if ($id) {
            $id = explode('_', $id);
            $belongs_to = $id[0];
            $belongs_to_id = $id[1];
            if ($belongs_to == 'user') {
                $belongs_to = User::find($belongs_to_id);
            }
            if ($belongs_to == 'client') {
                $belongs_to = Client::find($belongs_to_id);
            }
            $projects = $belongs_to->projects();
        } else {
            $projects = isAdminOrHasAllDataAccess() ? $this->workspace->projects() : $this->user->projects();
        }
        if ($user_id) {
            $user = User::find($user_id);
            $projects = $user->projects();
        }
        if ($client_id) {
            $client = Client::find($client_id);
            $projects = $client->projects();
        }
        if ($start_date_from && $start_date_to) {
            $projects->whereBetween('start_date', [$start_date_from, $start_date_to]);
        }
        if ($end_date_from && $end_date_to) {
            $projects->whereBetween('end_date', [$end_date_from, $end_date_to]);
        }
        $projects->when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });
        $projects->where($where);
        $totalprojects = $projects->count();

        $projects = $projects->orderBy($sort, $order)
            ->paginate(request("limit"))
            ->through(
                fn ($project) => [
                    'id' => $project->id,
                    'title' => "<a href='/projects/information/" . $project->id . "' target='_blank'><strong>" . $project->title . "</strong></a> <a href='javascript:void(0);' class='mx-2'><i class='bx " . ($project->is_favorite ? 'bxs' : 'bx') . "-star favorite-icon text-warning' data-favorite=" . $project->is_favorite . " data-id=" . $project->id . " title='" . ($project->is_favorite ? get_label('remove_favorite', 'Click to remove from favorite') : get_label('add_favorite', 'Click to mark as favorite')) . "'></i></a>",
                    'users' => $project->users,
                    'clients' => $project->clients,
                    'start_date' => format_date($project->start_date),
                    'end_date' => format_date($project->end_date),
                    'budget' => !empty($project->budget) && $project->budget !== null ? format_currency($project->budget) : '-',
                    'status_id' => "<span class='badge bg-label-" . $project->status->color . " me-1'>" . $project->status->title . "</span>",
                    'created_at' => format_date($project->created_at, 'H:i:s'),
                    'updated_at' => format_date($project->updated_at, 'H:i:s'),
                ]
            );
        foreach ($projects->items() as $project => $collection) {
            foreach ($collection['clients'] as $i => $client) {
                $collection['clients'][$i] = "<a href='/clients/profile/" . $client->id . "' target='_blank'><li class='avatar avatar-sm pull-up'  title='" . $client['first_name'] . " " . $client['last_name'] . "'>
                <img src='" . ($client['photo'] ? asset('storage/' . $client['photo']) : asset('storage/photos/no-image.jpg')) . "' alt='Avatar' class='rounded-circle' />
                </li></a>";
            };
        }

        foreach ($projects->items() as $project => $collection) {
            foreach ($collection['users'] as $i => $user) {
                $collection['users'][$i] = "<a href='/users/profile/" . $user->id . "' target='_blank'><li class='avatar avatar-sm pull-up'  title='" . $user['first_name'] . " " . $user['last_name'] . "'>
                <img src='" . ($user['photo'] ? asset('storage/' . $user['photo']) : asset('storage/photos/no-image.jpg')) . "' class='rounded-circle' />
                </li></a>";
            };
        }

        return response()->json([
            "rows" => $projects->items(),
            "total" => $totalprojects,
        ]);
    }

    public function update_favorite(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => true, 'message' => 'Project not found']);
        }

        $isFavorite = $request->input('is_favorite');

        // Update the project's favorite status
        $project->is_favorite = $isFavorite;
        $project->save();
        return response()->json(['error' => false]);
    }

    public function duplicate($id)
    {
        // Define the related tables for this meeting
        $relatedTables = ['users', 'clients', 'tasks', 'tags']; // Include related tables as needed

        // Use the general duplicateRecord function
        $duplicate = duplicateRecord(Project::class, $id, $relatedTables);

        if (!$duplicate) {
            return response()->json(['error' => true, 'message' => 'Project duplication failed.']);
        }

        if (request()->has('reload') && request()->input('reload') === 'true') {
            Session::flash('message', 'Project duplicated successfully.');
        }
        return response()->json(['error' => false, 'message' => 'Project duplicated successfully.', 'id' => $id]);
    }

    public function upload_media(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'integer|exists:projects,id'
            ]);

            $mediaIds = [];

            if ($request->hasFile('media_files')) {
                $project = Project::find($validatedData['id']);
                $mediaFiles = $request->file('media_files');

                foreach ($mediaFiles as $mediaFile) {
                    $mediaItem = $project->addMedia($mediaFile)
                        ->sanitizingFileName(function ($fileName) use ($project) {
                            // Replace special characters and spaces with hyphens
                            $sanitizedFileName = strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));

                            // Generate a unique identifier based on timestamp and random component
                            $uniqueId = time() . '_' . mt_rand(1000, 9999);

                            $extension = pathinfo($sanitizedFileName, PATHINFO_EXTENSION);
                            $baseName = pathinfo($sanitizedFileName, PATHINFO_FILENAME);

                            return "{$baseName}-{$uniqueId}.{$extension}";
                        })
                        ->toMediaCollection('project-media');

                    $mediaIds[] = $mediaItem->id;
                }


                Session::flash('message', 'File(s) uploaded successfully.');
                return response()->json(['error' => false, 'message' => 'File(s) uploaded successfully.', 'id' => $mediaIds, 'type' => 'media', 'parent_type' => 'project']);
            } else {
                Session::flash('error', 'No file(s) chosen.');
                return response()->json(['error' => true, 'message' => 'No file(s) chosen.']);
            }
        } catch (Exception $e) {
            // Handle the exception as needed
            Session::flash('error', 'An error occurred during file upload: ' . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'An error occurred during file upload: ' . $e->getMessage()]);
        }
    }





    public function get_media($id)
    {
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $project = Project::findOrFail($id);
        $media = $project->getMedia('project-media');

        if ($search) {
            $media = $media->filter(function ($mediaItem) use ($search) {
                return (
                    // Check if ID contains the search query
                    stripos($mediaItem->id, $search) !== false ||
                    // Check if file name contains the search query
                    stripos($mediaItem->file_name, $search) !== false ||
                    // Check if date created contains the search query
                    stripos($mediaItem->created_at->format('Y-m-d'), $search) !== false
                );
            });
        }
        $formattedMedia = $media->map(function ($mediaItem) {
            // Check if the disk is public
            $isPublicDisk = $mediaItem->disk == 'public' ? 1 : 0;

            // Generate file URL based on disk visibility
            $fileUrl = $isPublicDisk
                ? asset('storage/project-media/' . $mediaItem->file_name)
                : $mediaItem->getFullUrl();

            $fileExtension = pathinfo($fileUrl, PATHINFO_EXTENSION);

            // Check if file extension corresponds to an image type
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            $isImage = in_array(strtolower($fileExtension), $imageExtensions);

            if ($isImage) {
                $html = '<a href="' . $fileUrl . '" data-lightbox="project-media">';
                $html .= '<img src="' . $fileUrl . '" alt="' . $mediaItem->file_name . '" width="50">';
                $html .= '</a>';
            } else {
                $html = '<a href="' . $fileUrl . '" title=' . get_label('download', 'Download') . '>' . $mediaItem->file_name . '</a>';
            }

            return [
                'id' => $mediaItem->id,
                'file' => $html,
                'file_name' => $mediaItem->file_name,
                'file_size' => formatSize($mediaItem->size),
                'created_at' => format_date($mediaItem->created_at, 'H:i:s'),
                'updated_at' => format_date($mediaItem->updated_at, 'H:i:s'),
                'actions' => [
                    '<a href="' . $fileUrl . '" title=' . get_label('download', 'Download') . ' download>' .
                        '<i class="bx bx-download bx-sm"></i>' .
                        '</a>' .
                        '<button title=' . get_label('delete', 'Delete') . ' type="button" class="btn delete" data-id="' . $mediaItem->id . '" data-type="project-media">' .
                        '<i class="bx bx-trash text-danger"></i>' .
                        '</button>'
                ],
            ];
        });


        if ($order == 'asc') {
            $formattedMedia = $formattedMedia->sortBy($sort);
        } else {
            $formattedMedia = $formattedMedia->sortByDesc($sort);
        }

        return response()->json([
            'rows' => $formattedMedia->values()->toArray(),
            'total' => $formattedMedia->count(),
        ]);
    }

    public function delete_media($mediaId)
    {
        $mediaItem = Media::find($mediaId);

        if (!$mediaItem) {
            // Handle case where media item is not found
            return response()->json(['error' => true, 'message' => 'File not found.']);
        }

        // Delete media item from the database and disk
        $mediaItem->delete();

        return response()->json(['error' => false, 'message' => 'File deleted successfully.', 'id' => $mediaId, 'title' => $mediaItem->file_name, 'parent_id' => $mediaItem->model_id,  'type' => 'media', 'parent_type' => 'project']);
    }

    public function delete_multiple_media(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'ids' => 'required|array', // Ensure 'ids' is present and an array
            'ids.*' => 'integer|exists:media,id' // Ensure each ID in 'ids' is an integer and exists in the table
        ]);

        $ids = $validatedData['ids'];
        $deletedIds = [];
        $deletedTitles = [];
        $parentIds = [];
        // Perform deletion using validated IDs
        foreach ($ids as $id) {
            $media = Media::find($id);
            if ($media) {
                $deletedIds[] = $id;
                $deletedTitles[] = $media->file_name;
                $parentIds[] = $media->model_id;
                $media->delete();
            }
        }

        return response()->json(['error' => false, 'message' => 'Files(s) deleted successfully.', 'id' => $deletedIds, 'titles' => $deletedTitles, 'parent_id' => $parentIds, 'type' => 'media', 'parent_type' => 'project']);
    }

    public function store_milestone(Request $request)
    {
        $formFields = $request->validate([
            'project_id' => ['required'],
            'title' => ['required'],
            'status' => ['required'],
            'start_date' => ['required', 'before_or_equal:end_date'],
            'end_date' => ['required'],
            'cost' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'description' => ['nullable'],
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $formFields['start_date'] = format_date($start_date, null, "Y-m-d");
        $formFields['end_date'] = format_date($end_date, null, "Y-m-d");

        $formFields['workspace_id'] = $this->workspace->id;
        $formFields['created_by'] = isClient() ? 'c_' . $this->user->id : 'u_' . $this->user->id;


        $milestone = Milestone::create($formFields);

        return response()->json(['error' => false, 'message' => 'Milestone created successfully.', 'id' => $milestone->id, 'type' => 'milestone', 'parent_type' => 'project']);
    }

    public function get_milestones($id)
    {
        $project = Project::findOrFail($id);
        $search = request('search');
        $sort = (request('sort')) ? request('sort') : "id";
        $order = (request('order')) ? request('order') : "DESC";
        $status = isset($_REQUEST['status']) && $_REQUEST['status'] !== '' ? $_REQUEST['status'] : "";
        $start_date_from = (request('start_date_from')) ? request('start_date_from') : "";
        $start_date_to = (request('start_date_to')) ? request('start_date_to') : "";
        $end_date_from = (request('end_date_from')) ? request('end_date_from') : "";
        $end_date_to = (request('end_date_to')) ? request('end_date_to') : "";
        $milestones =  $project->milestones();
        if ($search) {
            $milestones = $milestones->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('cost', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        if ($start_date_from && $start_date_to) {
            $milestones = $milestones->whereBetween('start_date', [$start_date_from, $start_date_to]);
        }
        if ($end_date_from && $end_date_to) {
            $milestones  = $milestones->whereBetween('to_date', [$end_date_from, $end_date_to]);
        }
        if ($status) {
            $milestones  = $milestones->where('status', $status);
        }
        $total = $milestones->count();
        $milestones = $milestones->orderBy($sort, $order)


            ->paginate(request("limit"))
            ->through(function ($milestone) {
                if (strpos($milestone->created_by, 'u_') === 0) {
                    // The ID corresponds to a user
                    $creator = User::find(substr($milestone->created_by, 2)); // Remove the 'u_' prefix
                } elseif (strpos($milestone->created_by, 'c_') === 0) {
                    // The ID corresponds to a client
                    $creator = Client::find(substr($milestone->created_by, 2)); // Remove the 'c_' prefix                    
                }
                if ($creator !== null) {
                    $creator = $creator->first_name . ' ' . $creator->last_name;
                } else {
                    $creator = '-';
                }

                $statusBadge = '';

                if ($milestone->status == 'incomplete') {
                    $statusBadge = '<span class="badge bg-danger">' . get_label('incomplete', 'Incomplete') . '</span>';
                } elseif ($milestone->status == 'complete') {
                    $statusBadge = '<span class="badge bg-success">' . get_label('complete', 'Complete') . '</span>';
                }
                $progress = '<div class="demo-vertical-spacing">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: ' . $milestone->progress . '%" aria-valuenow="' . $milestone->progress . '" aria-valuemin="0" aria-valuemax="100">
                    
                  </div>
                </div>
              </div> <h6 class="mt-2">' . $milestone->progress . '%</h6>';

                return [
                    'id' => $milestone->id,
                    'title' => $milestone->title,
                    'status' => $statusBadge,
                    'progress' => $progress,
                    'cost' => format_currency($milestone->cost),
                    'start_date' => format_date($milestone->start_date),
                    'end_date' => format_date($milestone->end_date),
                    'created_by' => $creator,
                    'description' => $milestone->description,
                    'created_at' => format_date($milestone->created_at, 'H:i:s'),
                    'updated_at' => format_date($milestone->updated_at, 'H:i:s'),
                ];
            });



        return response()->json([
            "rows" => $milestones->items(),
            "total" => $total,
        ]);
    }

    public function get_milestone($id)
    {
        $ms = Milestone::findOrFail($id);
        return response()->json(['ms' => $ms]);
    }

    public function update_milestone(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'status' => ['required'],
            'start_date' => ['required', 'before_or_equal:end_date'],
            'end_date' => ['required'],
            'cost' => ['required', 'regex:/^\d+(\.\d+)?$/'],
            'progress' => ['required'],
            'description' => ['nullable'],
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $formFields['start_date'] = format_date($start_date, null, "Y-m-d");
        $formFields['end_date'] = format_date($end_date, null, "Y-m-d");

        $ms = Milestone::findOrFail($request->id);

        if ($ms->update($formFields)) {
            return response()->json(['error' => false, 'message' => 'Milestone updated successfully.', 'id' => $ms->id, 'type' => 'milestone', 'parent_type' => 'project']);
        } else {
            return response()->json(['error' => true, 'message' => 'Milestone couldn\'t updated.']);
        }
    }
    public function delete_milestone($id)
    {
        $ms = Milestone::findOrFail($id);
        DeletionService::delete(Milestone::class, $id, 'Milestone');
        return response()->json(['error' => false, 'message' => 'Milestone deleted successfully.', 'id' => $id, 'title' => $ms->title, 'type' => 'milestone']);
    }
    public function delete_multiple_milestones(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'ids' => 'required|array', // Ensure 'ids' is present and an array
            'ids.*' => 'integer|exists:milestones,id' // Ensure each ID in 'ids' is an integer and exists in the table
        ]);

        $ids = $validatedData['ids'];
        $deletedIds = [];
        $deletedTitles = [];
        // Perform deletion using validated IDs
        foreach ($ids as $id) {
            $ms = Milestone::findOrFail($id);
            $deletedIds[] = $id;
            $deletedTitles[] = $ms->title;
            DeletionService::delete(Milestone::class, $id, 'Milestone');
        }

        return response()->json(['error' => false, 'message' => 'Milestone(s) deleted successfully.', 'id' => $deletedIds, 'titles' => $deletedTitles, 'type' => 'milestone']);
    }
}
