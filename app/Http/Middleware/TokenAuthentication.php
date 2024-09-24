<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->cookie('token');

            $result = JWTToken::decodeToken($token);
            if ($result == 'unauthorized') {
                return redirect(route('home'));
            }
            $request->headers->set('id', $result->userId);
            $request->headers->set('email', $result->email);
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
