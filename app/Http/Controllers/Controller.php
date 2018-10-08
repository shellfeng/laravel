<?php

namespace App\Http\Controllers;

use App\Http\Utils\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param mixed $data
     * @param int $code
     * @param string $msg
     * @param string $type
     * @param mixed $info
     * @return Response
     */
    public function json($data, $code = 200, $msg = 'ok', $type = null, $info = null)
    {
        return json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return new Response($data, $msg, $code, $type, $info);
    }
}
