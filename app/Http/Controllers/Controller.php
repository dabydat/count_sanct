<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Método que genera un LOG en el archivo storage/logs/laravel.log.
     *
     * @param  $solicitud_id, $data
     * @return void()
     */
    public function handleExceptionLog($location, $mensaje)
    {
        Log::error($location, [
            'message' => $mensaje
        ]);
    }

    public function method($data)
    {
        return explode('.', $data)[1];
    }
}
