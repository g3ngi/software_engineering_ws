<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            if (!$query) {
                $results = collect([]);
                return view('search', ['results' => $results, 'query' => $query]);
            } else {
                $results = Search::addMany([
                    [Project::class, 'title'],
                    [Task::class, 'title'],
                    [User::class, 'first_name'],
                    [Client::class, 'first_name'],
                    [Meeting::class, 'title'],
                    [Workspace::class, 'title']
                ])
                    ->paginate(10)
                    ->beginWithWildcard()
                    ->search($query);

                return view('search', ['results' => $results, 'query' => $query]);
            }
        }else{
            return redirect('/home')->with('error','Please enter search keyword.');
        }
    }
}
