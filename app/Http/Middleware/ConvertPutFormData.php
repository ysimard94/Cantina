<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ConvertPutFormData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->isMethod('POST') && $request->has('_method')) {
        //     Log::info('photo', ['variable' => "middleware"]);
        //     $request->request->remove('_method');
        //     $request->setMethod('PUT');
        //     $request->request->add($request->all());
        // }
        return $next($request);
    }
}
