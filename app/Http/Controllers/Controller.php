<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (in_array($request->route()->getName(), ['payment.success', 'payment.fail'])) {
            Log::debug('Payment callback:', [
                'method' => $request->method(),
                'data' => $request->all(),
                'ip' => $request->ip()
            ]);
        }
        return $next($request);
    });
}
}