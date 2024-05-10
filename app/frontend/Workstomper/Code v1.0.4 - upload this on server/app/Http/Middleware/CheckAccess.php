<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $typeModel, $typeKey, $parameterName, $redirect = null)
    {
        $user = getAuthenticatedUser();
        // Extract the parameter from the route
        $itemId = $request->route($parameterName);
        // dd($typeKey);
        // Check if the user has the 'admin' role or if they have a access with the given ID
        if (isAdminOrHasAllDataAccess() || ($user->$typeKey->contains($typeModel::find($itemId)))) {
            return $next($request); // User is authorized, proceed with the request
        }

        if (!$request->ajax()) {
            return redirect('/' . $redirect)->with('error', get_label('un_authorized_action', 'Un authorized action.'));
        }
        Session::flash('error', get_label('un_authorized_action', 'Un authorized action.'));
        return response()->json(['error' => true, 'message' => get_label('un_authorized_action', 'Un authorized action.')]);
    }
}
