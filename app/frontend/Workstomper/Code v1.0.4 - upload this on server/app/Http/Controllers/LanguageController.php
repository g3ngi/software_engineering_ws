<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    protected $user;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            // fetch session and use it in entire class with constructor
            $this->user = getAuthenticatedUser();
            return $next($request);
        });
    }
    public function index()
    {
        $default_language = $this->user->lang;
        return view('settings.languages', compact('default_language'));
    }

    public function create()
    {

        return view('languages.create_language');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required'],
            'code' => ['required', 'unique:languages,code']

        ]);

        if (language::create($formFields)) {
            Session::flash('message', 'Language created successfully.');
            return response()->json(['error' => false]);
        } else {
        }
    }

    public function save_labels(Request $request, Language $lang)
    {
        $data = $request->except(["_token", "_method"]);

        $langstr = '';

        foreach ($data as $key => $value) {
            $label_data =  strip_tags($value);
            $label_key = $key;
            $langstr .= "'" . $label_key . "' => '$label_data'," . "\n";
        }
        $langstr_final = "<?php return [" . "\n\n\n" . $langstr . "];";

        $root = base_path("/resources/lang");
        $dir = $root . '/' . $request->langcode;

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $filename = $dir . '\labels.php';

        file_put_contents($filename, $langstr_final);

        Session::flash('message', 'Language labels saved successfully.');
        return response()->json(['error' => false]);
    }

    public function change($code)
    {
        // app()->setLocale($code);
        session()->put('locale', $code);
        return redirect('/settings/languages');
    }

    public function switch($locale)
    {
        session(['my_locale' => $locale]);

        return redirect()->back()->with('message', 'Language switched successfully.');
    }

    public function set_default(Request $request)
    {
        $formFields = $request->validate([
            'lang' => ['required']

        ]);
        $locale = $request->lang;
        if (Language::where('code', '=', $locale)->exists()) {
            $this->user->lang = $locale;
            if ($this->user->save()) {
                session(['my_locale' => $locale, 'locale' => $locale]);
                Session::flash('message', 'Primary language set successfully.');
                return response()->json(['error' => false]);
            } else {
                return response()->json(['error' => true, 'message' => 'Primary language couldn\'t set.']);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'Invalid language.']);
        }
    }
}
