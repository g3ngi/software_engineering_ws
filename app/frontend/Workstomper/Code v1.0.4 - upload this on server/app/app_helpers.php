<?php

use App\Models\Update;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\User;
use App\Models\Client;
use App\Models\LeaveEditor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

if (!function_exists('get_timezone_array')) {
    // 1.Get Time Zone
    function get_timezone_array()
    {
        $list = DateTimeZone::listAbbreviations();
        $idents = DateTimeZone::listIdentifiers();

        $data = $offset = $added = array();
        foreach ($list as $abbr => $info) {
            foreach ($info as $zone) {
                if (
                    !empty($zone['timezone_id'])
                    and
                    !in_array($zone['timezone_id'], $added)
                    and
                    in_array($zone['timezone_id'], $idents)
                ) {
                    $z = new DateTimeZone($zone['timezone_id']);
                    $c = new DateTime("", $z);
                    $zone['time'] = $c->format('h:i A');
                    $offset[] = $zone['offset'] = $z->getOffset($c);
                    $data[] = $zone;
                    $added[] = $zone['timezone_id'];
                }
            }
        }

        array_multisort($offset, SORT_ASC, $data);
        $i = 0;
        $temp = array();
        foreach ($data as $key => $row) {
            $temp[0] = $row['time'];
            $temp[1] = formatOffset($row['offset']);
            $temp[2] = $row['timezone_id'];
            $options[$i++] = $temp;
        }

        return $options;
    }
}
if (!function_exists('formatOffset')) {
    function formatOffset($offset)
    {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int) abs($hours);
        $minutes = (int) abs($remainder / 60);
        if ($hour == 0 and $minutes == 0) {
            $sign = ' ';
        }
        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0');
    }
}
if (!function_exists('relativeTime')) {
    function relativeTime($time)
    {
        if (!ctype_digit($time))
            $time = strtotime($time);
        $d[0] = array(1, "second");
        $d[1] = array(60, "minute");
        $d[2] = array(3600, "hour");
        $d[3] = array(86400, "day");
        $d[4] = array(604800, "week");
        $d[5] = array(2592000, "month");
        $d[6] = array(31104000, "year");

        $w = array();

        $return = "";
        $now = time();
        $diff = ($now - $time);
        $secondsLeft = $diff;

        for ($i = 6; $i > -1; $i--) {
            $w[$i] = intval($secondsLeft / $d[$i][0]);
            $secondsLeft -= ($w[$i] * $d[$i][0]);
            if ($w[$i] != 0) {
                $return .= abs($w[$i]) . " " . $d[$i][1] . (($w[$i] > 1) ? 's' : '') . " ";
            }
        }

        $return .= ($diff > 0) ? "ago" : "left";
        return $return;
    }
}
if (!function_exists('get_settings')) {

    function get_settings($variable)
    {
        $fetched_data = Setting::all()->where('variable', $variable)->values();
        if (isset($fetched_data[0]['value']) && !empty($fetched_data[0]['value'])) {
            if (isJson($fetched_data[0]['value'])) {
                $fetched_data = json_decode($fetched_data[0]['value'], true);
            }
            return $fetched_data;
        }
    }
}
if (!function_exists('isJson')) {
    function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
if (!function_exists('create_label')) {
    function create_label($variable, $title = '', $locale = '')
    {
        if ($title == '') {
            $title = $variable;
        }
        return "
            
            <div class='mb-3 col-md-6'>
                        <label class='form-label' for='end_date'>$title</label>
                        <div class='input-group input-group-merge'>
                            <input type='text' name='$variable' class='form-control' value='" . get_label($variable, $title, $locale) . "'>
                        </div>
                    </div>
            
            ";
    }
}

if (!function_exists('get_label')) {

    function get_label($label, $default, $locale = '')
    {
        if (Lang::has('labels.' . $label, $locale)) {
            return trans('labels.' . $label, [], $locale);
        } else {
            return $default;
        }
    }
}
if (!function_exists('empty_state')) {

    function empty_state($url)
    {
        return "
    <div class='card text-center'>
    <div class='card-body'>
        <div class='misc-wrapper'>
            <h2 class='mb-2 mx-2'>Data Not Found </h2>
            <p class='mb-4 mx-2'>Oops! 😖 Data doesn't exists.</p>
            <a href='/$url' class='btn btn-primary'>Create now</a>
            <div class='mt-3'>
                <img src='../assets/img/illustrations/page-misc-error-light.png' alt='page-misc-error-light' width='500' class='img-fluid' data-app-dark-img='illustrations/page-misc-error-dark.png' data-app-light-img='illustrations/page-misc-error-light.png' />
            </div>
        </div>
    </div>
</div>";
    }
}
if (!function_exists('format_date')) {
    function format_date($date, $time = null, $format = null, $apply_timezone = true)
    {
        if ($date) {
            $format = $format ?? get_php_date_format();
            $time = $time ?? '';

            $date = $time != '' ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::parse($date);

            if ($time !== '') {
                if ($apply_timezone) {
                    $date->setTimezone(config('app.timezone'));
                }
                $format .= ' ' . $time;
            }

            return $date->format($format);
        } else {
            return '-';
        }
    }
}
if (!function_exists('getAuthenticatedUser')) {

    function getAuthenticatedUser()
    {
        // Check the 'web' guard (users)
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }

        // Check the 'clients' guard (clients)
        if (Auth::guard('client')->check()) {
            return Auth::guard('client')->user();
        }

        // No user is authenticated
        return null;
    }
}
if (!function_exists('isUser')) {

    function isUser()
    {
        return Auth::guard('web')->check(); // Assuming 'role' is a field in the user model.
    }
}
if (!function_exists('isClient')) {

    function isClient()
    {
        return Auth::guard('client')->check(); // Assuming 'role' is a field in the user model.
    }
}
if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($title, $model, $id = null)
    {
        $slug = Str::slug($title);
        $count = 2;

        // If an ID is provided, add a where clause to exclude it
        if ($id !== null) {
            while ($model::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = Str::slug($title) . '-' . $count;
                $count++;
            }
        } else {
            while ($model::where('slug', $slug)->exists()) {
                $slug = Str::slug($title) . '-' . $count;
                $count++;
            }
        }

        return $slug;
    }
}
if (!function_exists('duplicateRecord')) {
    function duplicateRecord($model, $id, $relatedTables = [])
    {
        // Find the original record with related data
        $originalRecord = $model::with($relatedTables)->find($id);
        if (!$originalRecord) {
            return false; // Record not found
        }
        // Start a new database transaction to ensure data consistency
        DB::beginTransaction();

        try {
            // Duplicate the original record
            $duplicateRecord = $originalRecord->replicate();
            $duplicateRecord->save();

            foreach ($relatedTables as $relatedTable) {
                if ($relatedTable === 'tasks') {
                    // Handle 'tasks' relationship separately
                    foreach ($originalRecord->$relatedTable as $task) {
                        // Duplicate the related task
                        $duplicateTask = $task->replicate();
                        $duplicateTask->project_id = $duplicateRecord->id;
                        $duplicateTask->save();
                        foreach ($task->users as $user) {
                            // Attach the duplicated user to the duplicated task
                            $duplicateTask->users()->attach($user->id);
                        }
                    }
                }
            }
            // Handle many-to-many relationships separately
            if (in_array('users', $relatedTables)) {
                $originalRecord->users()->each(function ($user) use ($duplicateRecord) {
                    $duplicateRecord->users()->attach($user->id);
                });
            }

            if (in_array('clients', $relatedTables)) {
                $originalRecord->clients()->each(function ($client) use ($duplicateRecord) {
                    $duplicateRecord->clients()->attach($client->id);
                });
            }

            if (in_array('tags', $relatedTables)) {
                $originalRecord->tags()->each(function ($tag) use ($duplicateRecord) {
                    $duplicateRecord->tags()->attach($tag->id);
                });
            }

            // Commit the transaction
            DB::commit();

            return $duplicateRecord;
        } catch (\Exception $e) {
            // Handle any exceptions and rollback the transaction on failure
            DB::rollback();

            return false;
        }
    }
}
if (!function_exists('is_admin_or_leave_editor')) {
    function is_admin_or_leave_editor()
    {
        $user = getAuthenticatedUser();

        // Check if the user is an admin or a leave editor based on their presence in the leave_editors table
        if ($user->hasRole('admin') || LeaveEditor::where('user_id', $user->id)->exists()) {
            return true;
        }
        return false;
    }
}
if (!function_exists('get_php_date_format')) {
    function get_php_date_format()
    {
        $general_settings = get_settings('general_settings');
        $date_format = $general_settings['date_format'] ?? 'DD-MM-YYYY|d-m-Y';
        $date_format = explode('|', $date_format);
        return $date_format[1];
    }
}
if (!function_exists('get_system_update_info')) {
    function get_system_update_info()
    {
        $updatePath = Config::get('constants.UPDATE_PATH');
        $updaterPath = $updatePath . 'updater.json';
        $subDirectory = (File::exists($updaterPath) && File::exists($updatePath . 'update/updater.json')) ? 'update/' : '';

        if (File::exists($updaterPath) || File::exists($updatePath . $subDirectory . 'updater.json')) {
            $updaterFilePath = File::exists($updaterPath) ? $updaterPath : $updatePath . $subDirectory . 'updater.json';
            $updaterContents = File::get($updaterFilePath);

            // Check if the file contains valid JSON data
            if (!json_decode($updaterContents)) {
                throw new \RuntimeException('Invalid JSON content in updater.json');
            }

            $linesArray = json_decode($updaterContents, true);

            if (!isset($linesArray['version'], $linesArray['previous'], $linesArray['manual_queries'], $linesArray['query_path'])) {
                throw new \RuntimeException('Invalid JSON structure in updater.json');
            }
        } else {
            throw new \RuntimeException('updater.json does not exist');
        }

        $dbCurrentVersion = Update::latest()->first();
        $data['db_current_version'] = $dbCurrentVersion ? $dbCurrentVersion->version : '1.0.0';
        if ($data['db_current_version'] == $linesArray['version']) {
            $data['updated_error'] = true;
            $data['message'] = 'Oops!. This version is already updated into your system. Try another one.';
            return $data;
        }
        if ($data['db_current_version'] == $linesArray['previous']) {
            $data['file_current_version'] = $linesArray['version'];
        } else {
            $data['sequence_error'] = true;
            $data['message'] = 'Oops!. Update must performed in sequence.';
            return $data;
        }

        $data['query'] = $linesArray['manual_queries'];
        $data['query_path'] = $linesArray['query_path'];

        return $data;
    }
}
if (!function_exists('escape_array')) {
    function escape_array($array)
    {
        if (empty($array)) {
            return $array;
        }

        $db = DB::connection()->getPdo();

        if (is_array($array)) {
            return array_map(function ($value) use ($db) {
                return $db->quote($value);
            }, $array);
        } else {
            // Handle single non-array value
            return $db->quote($array);
        }
    }
}
if (!function_exists('isEmailConfigured')) {

    function isEmailConfigured()
    {
        $email_settings = get_settings('email_settings');
        if (
            isset($email_settings['email']) && !empty($email_settings['email']) &&
            isset($email_settings['password']) && !empty($email_settings['password']) &&
            isset($email_settings['smtp_host']) && !empty($email_settings['smtp_host']) &&
            isset($email_settings['smtp_port']) && !empty($email_settings['smtp_port'])
        ) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('get_current_version')) {

    function get_current_version()
    {
        $dbCurrentVersion = Update::latest()->first();
        return $dbCurrentVersion ? $dbCurrentVersion->version : '1.0.0';
    }
}

if (!function_exists('isAdminOrHasAllDataAccess')) {
    function isAdminOrHasAllDataAccess($type = null, $id = null)
    {
        if ($type == 'user' && $id !== null) {
            $user = User::find($id);
            if ($user) {
                return $user->hasRole('admin') || $user->can('access_all_data') ? true : false;
            }
        } elseif ($type == 'client' && $id !== null) {
            $client = Client::find($id);
            if ($client) {
                return $client->hasRole('admin') || $client->can('access_all_data') ? true : false;
            }
        } elseif ($type == null && $id == null) {
            return getAuthenticatedUser()->hasRole('admin') || getAuthenticatedUser()->can('access_all_data') ? true : false;
        }

        return false;
    }
}


if (!function_exists('getControllerNames')) {

    function getControllerNames()
    {
        $controllersPath = app_path('Http/Controllers');
        $files = File::files($controllersPath);

        $excludedControllers = [
            'ActivityLogController',
            'Controller',
            'HomeController',
            'InstallerController',
            'LanguageController',
            'ProfileController',
            'RolesController',
            'SearchController',
            'SettingsController',
            'UpdaterController',
            'EstimatesInvoicesController',
        ];

        $controllerNames = [];

        foreach ($files as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);

            // Skip controllers in the excluded list
            if (in_array($fileName, $excludedControllers)) {
                continue;
            }

            if (str_ends_with($fileName, 'Controller')) {
                // Convert to singular form, snake_case, and remove 'Controller' suffix
                $controllerName = Str::snake(Str::singular(str_replace('Controller', '', $fileName)));
                $controllerNames[] = $controllerName;
            }
        }

        // Add manually defined types
        $manuallyDefinedTypes = [
            'contract_type',
            'media',
            'estimate',
            'invoice'
            // Add more types as needed
        ];

        $controllerNames = array_merge($controllerNames, $manuallyDefinedTypes);

        return $controllerNames;
    }
    if (!function_exists('formatSize')) {
        function formatSize($bytes)
        {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];

            $i = 0;
            while ($bytes >= 1024 && $i < count($units) - 1) {
                $bytes /= 1024;
                $i++;
            }

            return round($bytes, 2) . ' ' . $units[$i];
        }
    }
    if (!function_exists('getStatusColor')) {
        function getStatusColor($status)
        {
            switch ($status) {
                case 'sent':
                    return 'primary';
                case 'accepted':
                case 'fully_paid':
                    return 'success';
                case 'draft':
                    return 'secondary';
                case 'declined':
                case 'due':
                    return 'danger';
                case 'expired':
                case 'partially_paid':
                    return 'warning';
                case 'not_specified':
                    return 'secondary';
                default:
                    return 'info';
            }
        }
    }
    if (!function_exists('getStatusCount')) {
        function getStatusCount($status, $type)
        {
            $query = DB::table('estimates_invoices')->where('type', $type);

            if (!empty($status)) {
                $query->where('status', $status);
            }

            return $query->count();
        }
    }

    if (!function_exists('format_currency')) {
        function format_currency($amount, $is_currency_symbol = 1)
        {
            $general_settings = get_settings('general_settings');
            $currency_symbol = $general_settings['currency_symbol'] ?? '₹';
            $currency_format = $general_settings['currency_formate'] ?? 'comma_separated';
            $decimal_points = intval($general_settings['decimal_points_in_currency'] ?? '2');
            $currency_symbol_position = $general_settings['currency_symbol_position'] ?? 'before';

            // Determine the appropriate separators based on the currency format
            $thousands_separator = ($currency_format == 'comma_separated') ? ',' : '.';
            // Format the amount with the determined separators
            $formatted_amount = number_format($amount, $decimal_points, '.', $thousands_separator);
            if ($is_currency_symbol) {
                // Format currency symbol position
                if ($currency_symbol_position === 'before') {
                    $currency_amount = $currency_symbol . ' ' . $formatted_amount;
                } else {
                    $currency_amount = $formatted_amount . ' ' . $currency_symbol;
                }
                return $currency_amount;
            }
            return $formatted_amount;
        }
    }

    function get_tax_data($tax_id, $total_amount, $currency_symbol = 0)
    {
        // Check if tax_id is not empty
        if ($tax_id != '') {
            // Retrieve tax data from the database using the tax_id
            $tax = Tax::find($tax_id);

            // Check if tax data is found
            if ($tax) {
                // Get tax rate and type
                $taxRate = $tax->amount;
                $taxType = $tax->type;

                // Calculate tax amount based on tax rate and type
                $taxAmount = 0;
                $disp_tax = '';

                if ($taxType == 'percentage') {
                    $taxAmount = ($total_amount * $tax->percentage) / 100;
                    $disp_tax = format_currency($taxAmount, $currency_symbol) . '(' . $tax->percentage . '%)';
                } elseif ($taxType == 'amount') {
                    $taxAmount = $taxRate;
                    $disp_tax = format_currency($taxAmount, $currency_symbol);
                }

                // Return the calculated tax data
                return [
                    'taxAmount' => $taxAmount,
                    'taxType' => $taxType,
                    'dispTax' => $disp_tax,
                ];
            }
        }

        // Return empty data if tax_id is empty or tax data is not found
        return [
            'taxAmount' => 0,
            'taxType' => '',
            'dispTax' => '',
        ];
    }
}
