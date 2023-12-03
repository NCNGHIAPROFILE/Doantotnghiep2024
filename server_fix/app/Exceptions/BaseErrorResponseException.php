<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;


class BaseErrorResponseException extends RuntimeException implements Responsable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string|null
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $invalidKeys;
    protected $defaultErrorCodes = [
        400 => 'bad_request',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'not_found',
        405 => 'method_not_allowed',
        422 => 'validation_error',
        500 => 'internal_server_error',
    ];
    public function __construct(string $message = '', int $statusCode = 500)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->invalidKeys = [];
    }

    /**
     * @param string $message
     */
    public function setErrorMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $errorCode
     */
    public function setErrorCode(string $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @param string $invalidKey
     */
    public function setInvalidKey(string $invalidKey, bool $isValid = false): void
    {
        $this->invalidKeys[$invalidKey] = $isValid;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return null|string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @return null|string
     */
    public function getInvalidKey()
    {
        return $this->invalidKeys;
    }

    public function toResponse($request)
    {
        return new JsonResponse(
            $this->getBasicResponse(),
            $this->getStatusCode()
        );
    }

    protected function getBasicResponse()
    {
        return array_merge([
            'result' => false,
            'error_code' => $this->getErrorCode() ?? $this->getDefaultErrorCode(),
            'message' => $this->getErrorMessage(),
        ], $this->getInvalidKey());
    }

    protected function getDefaultErrorCode(): string
    {
        return $this->defaultErrorCodes[$this->getStatusCode()];
    }
}
