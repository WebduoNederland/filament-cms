<?php

namespace WebduoNederland\FilamentCms\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use WebduoNederland\FilamentCms\Models\FilamentCmsRedirect;

class RedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse|Closure
    {
        $path = $request->path();

        /** @var ?FilamentCmsRedirect $redirect */
        $redirect = FilamentCmsRedirect::query()
            ->where('from_slug', '=', $path)
            ->first();

        if ($redirect) {
            $redirect->timestamps = false;

            $redirect->hits++;

            $redirect->save();

            return redirect()->away($redirect->to, (int) $redirect->type);
        }

        return $next($request);
    }
}
