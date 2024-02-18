<?php

namespace Infrastructure;
use core\exceptions\constants\HttpExceptionConstants;
use core\exceptions\handlers\ADODBExceptionhandler;
use core\exceptions\handlers\HttpExceptionHandler;
use core\exceptions\InternalServerErrorException;
use Exception;
use http\Response;
use tribunal\exceptions\handlers\TribunalExceptionHandler;

class ExceptionHandler
{
    private $httpExceptionHandler;
    private $tribunalExceptionHandler;
    private $ADODBExceptionhandler;

    public function __construct()
    {
        $this->httpExceptionHandler = new HttpExceptionHandler();
        $this->ADODBExceptionhandler = new ADODBExceptionhandler();

        if (!IS_DEV) {
            error_reporting(0);
            ini_set("display_errors", 0);
        }
    }

    public function customErrorHandler($errno, $errstr, $errfile, $errline)
    {
        $statusCode = 500;
        switch ($errno) {
            case E_USER_ERROR:
                $statusCode = 400; // Bad Request
                break;
            case E_USER_WARNING:
            case E_WARNING:
                $statusCode = 422; // Unprocessable Entity
                break;
            case E_USER_NOTICE:
            case E_NOTICE:
                $statusCode = 200; // OK (tratado como aviso)
                break;
        }

        $response = new Response($errstr, $statusCode);
        $response->send();
    }

    public function handleFatalError() {
        $error = error_get_last();
        if ($error !== null && $error['type'] === E_ERROR) {
            $response = new Response(HttpExceptionConstants::INTERNAL_SERVER_ERROR_MESSAGE, HttpExceptionConstants::INTERNAL_SERVER_ERROR_CODE);
            $response->send();
        }
    }

    public function handle(Exception $e)
    {
        if($this->ADODBExceptionhandler->canHandle($e)){
            return $response = $this->ADODBExceptionhandler->handle($e);
        }

        if ($this->httpExceptionHandler->canHandle($e)) {
            return $response = $this->httpExceptionHandler->handle($e);
        }

        if($e instanceof Exception){
            return new Response($e->getMessage(), $e->getCode());
        }

        if (IS_DEV) {
            pred($e);
        } else {
            return new Response(HttpExceptionConstants::INTERNAL_SERVER_ERROR_MESSAGE, HttpExceptionConstants::INTERNAL_SERVER_ERROR_CODE);
        }
    }
}