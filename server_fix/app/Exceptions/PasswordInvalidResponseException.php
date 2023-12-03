<?php

namespace App\Exceptions;


class PasswordInvalidResponseException extends BaseErrorResponseException
{
    public function toResponse($request)
    {
        $this->setErrorMessage('Failed login.');
        $this->setStatusCode(401);
        $this->setInvalidKey('name', true);
        $this->setInvalidKey('password');
        return parent::toResponse($request);
    }
}
