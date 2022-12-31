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

    public function getAction($route, $id)
    {
        $actions = '';
        $actions .= "<a class='btn btn-outline-primary btn-sm mr-2' href='" . route($route . '.show', $id) . "' title='Ver'><i class='fa fa-eye'></i></a>";
        $actions .= "<a class='btn btn-outline-primary btn-sm' href='" . route($route . '.edit', $id) . "' title='Editar'><i class='fa fa-edit'></i></a>";
        return "<div class='text-center d-flex justify-content-around'>" . $actions . "</div>";
    }
}
