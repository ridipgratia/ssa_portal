<?php

namespace App\Http\Middleware;

use App\our_modules\user_modules\CheckAuthModule;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleLoggedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $check_auth_module = new CheckAuthModule();
        try {
            $check_auth = $check_auth_module->checkLoggedIn()->checkOneDeviceLogged();
        } catch (Exception $err) {
            return response()->json(['status' => 301, 'message' => "Server error at authtetication"]);
        }
        if (!$check_auth->check_logged_in) {
            return response()->json(['status' => 301, 'message' => $check_auth->auth_message]);
        }
        return $next($request);
    }
}
