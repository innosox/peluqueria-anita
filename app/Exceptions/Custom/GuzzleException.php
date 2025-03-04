<?php

namespace App\Exceptions\Custom;

use RuntimeException;
use Illuminate\Http\Response;

class GuzzleException extends RuntimeException
{
    private $statusCode;

    /**
     *
     * @param  string  $message
     * @param  \Throwable  $previous
     * @return void
     */
    public function __construct(string $message = '', \Throwable $previous = null)
    {
        $this->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

        parent::__construct($message, $this->statusCode, $previous);
    }

    /**
     *
     * @return \Illuminate\Http\Response  $statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
