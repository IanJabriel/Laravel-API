<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming HTTP request and return the response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, $next)
    {
        $allowedOrigins = [
            '*', // Allow requests from all origins (for testing)
            //'https://example.com', // Allow requests from specific origin
        ];

        $allowedMethods = [
            'GET',
            'POST',
            'PUT',
            'DELETE',
        ];

        $allowedHeaders = [
            'Content-Type',
            'Authorization',
            'X-Requested-With',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json([
                'message' => 'CORS request allowed',
            ], 200)->header('Access-Control-Allow-Origin', $request->header('Origin'))
                ->header('Access-Control-Allow-Methods', implode(', ', $allowedMethods))
                ->header('Access-Control-Allow-Headers', implode(', ', $allowedHeaders));
        }

        return $next($request)->header('Access-Control-Allow-Origin', $request->header('Origin'))
            ->header('Access-Control-Allow-Methods', implode(', ', $allowedMethods))
            ->header('Access-Control-Allow-Headers', implode(', ', $allowedHeaders));
    }
}
?>