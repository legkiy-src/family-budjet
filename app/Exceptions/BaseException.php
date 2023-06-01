<?php


namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class BaseException extends \Exception
{
    public static int $statusCode = Response::HTTP_BAD_REQUEST;
}
