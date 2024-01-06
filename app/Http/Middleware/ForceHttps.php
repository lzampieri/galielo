<?php
namespace App\Http\Middleware;
use Closure;
class ForceHttps
{
    public static function isHTTPS()
    {
        // Checking the port
        if ($_SERVER['SERVER_PORT'] == 443) {
            return true;
        }
        // Checking the direct protocol
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            return true;
        }
        // Checkinf the forwarded protocol
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
            return true;
        }
        return false;
    }
    public function handle($request, Closure $next)
    {
        if (!ForceHttps::isHTTPS()) {
            return redirect(env('APP_URL'));
        }
        return $next($request);
    }
}