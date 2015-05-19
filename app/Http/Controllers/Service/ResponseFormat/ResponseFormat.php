<?php namespace App\Http\Controllers\Service\ResponseFormat;

class ResponseFormat extends AbstractResponseFormat {

    public function __construct($code, $body = null) {
        $code = !($code === 0) ?
            $code : Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED;

        $this->setCode($code);
        $this->setBody($body);
    }

    public function getData() {
        return array(
            'code'    => $this->getCode(),
            'message' => $this->getMessage(),
            'body'    => is_null($this->getBody()) ? '' : $this->getBody()
        );
    }
}