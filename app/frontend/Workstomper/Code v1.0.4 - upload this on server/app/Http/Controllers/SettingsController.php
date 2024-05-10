<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $timezones = get_timezone_array();
        return view('settings.general_settings', compact('timezones'));
    }

    public function pusher()
    {
        return view('settings.pusher_settings');
    }

    public function email()
    {
        return view('settings.email_settings');
    }

    public function media_storage()
    {
        return view('settings.media_storage_settings');
    }

    public function store_general_settings(Request $request)
    {
        $request->validate([
            'company_title' => ['required'],
            'timezone' => ['required'],
            'currency_full_form' => ['required'],
            'currency_symbol' => ['required'],
            'currency_code' => ['required'],
            'date_format' => ['required']
        ]);
        $settings = [];
        $fetched_data = Setting::where('variable', 'general_settings')->first();
        if ($fetched_data != null) {
            $settings = json_decode($fetched_data->value, true);
        }
        $form_val = $request->except('_token', '_method', 'redirect_url');
        $old_logo = isset($settings['full_logo']) && !empty($settings['full_logo']) ? $settings['full_logo'] : '';
        if ($request->hasFile('full_logo')) {
            Storage::disk('public')->delete($old_logo);
            $form_val['full_logo'] = $request->file('full_logo')->store('logos', 'public');
        } else {
            $form_val['full_logo'] = $old_logo;
        }

        $old_half_logo = isset($settings['half_logo']) && !empty($settings['half_logo']) ? $settings['half_logo'] : '';
        if ($request->hasFile('half_logo')) {
            Storage::disk('public')->delete($old_half_logo);
            $form_val['half_logo'] = $request->file('half_logo')->store('logos', 'public');
        } else {
            $form_val['half_logo'] = $old_half_logo;
        }

        $old_favicon = isset($settings['favicon']) && !empty($settings['favicon']) ? $settings['favicon'] : '';
        if ($request->hasFile('favicon')) {
            Storage::disk('public')->delete($old_favicon);
            $form_val['favicon'] = $request->file('favicon')->store('logos', 'public');
        } else {
            $form_val['favicon'] = $old_favicon;
        }
        $data = [
            'variable' => 'general_settings',
            'value' => json_encode($form_val),
        ];

        if ($fetched_data == null) {
            Setting::create($data);
        } else {
            Setting::where('variable', 'general_settings')->update($data);
        }
        session()->put('date_format', $request->input('date_format'));

        Session::flash('message', 'Settings saved successfully.');
        return response()->json(['error' => false]);
    }

    public function store_pusher_settings(Request $request)
    {
        $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_app_key' => ['required'],
            'pusher_app_secret' => ['required'],
            'pusher_app_cluster' => ['required']
        ]);
        $fetched_data = Setting::where('variable', 'pusher_settings')->first();
        $form_val = $request->except('_token', '_method', 'redirect_url');
        $data = [
            'variable' => 'pusher_settings',
            'value' => json_encode($form_val),
        ];

        if ($fetched_data == null) {
            Setting::create($data);
        } else {
            Setting::where('variable', 'pusher_settings')->update($data);
        }

        Session::flash('message', 'Settings saved successfully.');
        return response()->json(['error' => false]);
    }

    public function store_email_settings(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'smtp_host' => ['required'],
            'smtp_port' => ['required'],
            'email_content_type' => ['required'],
            'smtp_encryption' => ['required']
        ]);
        $fetched_data = Setting::where('variable', 'email_settings')->first();
        $form_val = $request->except('_token', '_method', 'redirect_url');
        $data = [
            'variable' => 'email_settings',
            'value' => json_encode($form_val),
        ];

        if ($fetched_data == null) {
            Setting::create($data);
        } else {
            Setting::where('variable', 'email_settings')->update($data);
        }
        Session::flash('message', 'Settings saved successfully.');
        return response()->json(['error' => false]);
    }

    public function store_media_storage_settings(Request $request)
    {
        $request->validate([
            'media_storage_type' => 'required|in:local,s3',
            's3_key' => $request->input('media_storage_type') === 's3' ? 'required' : 'nullable',
            's3_secret' => $request->input('media_storage_type') === 's3' ? 'required' : 'nullable',
            's3_region' => $request->input('media_storage_type') === 's3' ? 'required' : 'nullable',
            's3_bucket' => $request->input('media_storage_type') === 's3' ? 'required' : 'nullable',
        ]);
        $fetched_data = Setting::where('variable', 'media_storage_settings')->first();
        $form_val = $request->except('_token', '_method', 'redirect_url');
        $data = [
            'variable' => 'media_storage_settings',
            'value' => json_encode($form_val),
        ];

        if ($fetched_data == null) {
            Setting::create($data);
        } else {
            Setting::where('variable', 'media_storage_settings')->update($data);
        }
        Session::flash('message', 'Settings saved successfully.');
        return response()->json(['error' => false]);
    }
}
