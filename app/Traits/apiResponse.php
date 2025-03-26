<?php

namespace App\Traits;


trait ApiResponse
{

    //OK STATUS
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;
    public const NO_CONTENT = 204;

    //ERROR STATUS
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const CONFLICT = 409;
    public const UNPROCESSABLE = 422;
    public const TOO_MANY_REQUESTS = 429;

    //SERVER ERROR
    public const SERVER_ERROR = 500;
    public const BAD_GATEWAY = 502;
    public const GATEWAY_TIMEOUT = 504;

    protected function ok($message, $data = []){ return $this->response($message, SELF::OK, $data);}
    protected function created($message, $data = []){ return $this->response($message, SELF::CREATED, $data);}
    protected function accepted($message, $data = []){ return $this->response($message, SELF::ACCEPTED, $data);}
    protected function noContent($message = 'No Content', $data = []){ return $this->response($message, SELF::NO_CONTENT, $data);}

    protected function badRequest($message, $data = []){ return $this->response($message, SELF::BAD_REQUEST, $data);}
    protected function unauthorized($message, $data = []){ return $this->response($message, SELF::UNAUTHORIZED, $data);}
    protected function forbidden($message, $data = []){ return $this->response($message, SELF::FORBIDDEN, $data);}
    protected function notFound($message, $data = []){ return $this->response($message, SELF::NOT_FOUND, $data);}
    protected function methodNotAllowed($message, $data = []){ return $this->response($message, SELF::METHOD_NOT_ALLOWED, $data);}
    protected function tooManyRequest($message, $data = []){ return $this->response($message, SELF::TOO_MANY_REQUESTS, $data);}
    protected function unprocessable($message, $data = []){ return $this->response($message, SELF::UNPROCESSABLE, $data);}
    protected function conflict($message, $data = []){ return $this->response($message, SELF::CONFLICT, $data);}

    protected function serverError($message, $data = []){ return $this->response($message, SELF::SERVER_ERROR, $data);}
    protected function badGateWay($message, $data = []){ return $this->response($message, SELF::BAD_GATEWAY, $data);}
    protected function gatewayTimeout($message, $data = []){ return $this->response($message, SELF::GATEWAY_TIMEOUT, $data);}
    
    public function response($message, $statusCode, $data = [])
    {
        $response['status'] = $statusCode;
        $response['message'] = $message;
        if (!empty($data)) {
            if($statusCode < 400){
                $response['data'] = $data;
            }else{
                $response['error'] = $data;
            }
        }
        $response['success'] = $statusCode < 400 ? true : false;
        return response()->json($response, $statusCode);
    }

}
