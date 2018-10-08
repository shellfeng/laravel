<?php

namespace App\Http\Utils;


class Response extends \Illuminate\Http\Response
{

    /**
     * Response constructor.
     * @param mixed $data
     * @param string $msg
     * @param int $code
     * @param string $type
     * @param mixed $info
     * @param int $status
     * @param array $headers
     */
    public function __construct($data = null, $msg = '', $code = 200, $type = null, $info = null, $status = 200, array $headers = array())
    {
        parent::__construct([
            'msg'     => $msg,
            'code'    => $code,
            'data'    => $data,
            'special' => [
                'type' => $type,
                'info' => $info,
            ],
        ], $status, $headers);
    }

}