<?php

namespace App\Traits;

trait ResponseJsonTrait
{

    private function data($data)
    {
        return $data === null ? $data = new \stdClass() : $data;
    }
    public function responseJson($message, $data = null, $code = null)
    {
        return response(
            [
                'status' => $code,
                'message' => $message,
                'data' => ($this->data($data)) ? $this->data($data) : ''
            ],
            $code
        );
    }
}
