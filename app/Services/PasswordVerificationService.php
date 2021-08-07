<?php


namespace App\Services;


use Exception;

class PasswordVerificationService
{
    /**
     * @param string $password
     */
    public function verify($password)
    {
        throw_if(is_null($password), Exception::class, 'password should not be null');
        throw_if(strlen($password) < 8, Exception::class, 'password should be larger than 8 chars');
        throw_if(
            !preg_match('/[A-Z]/', $password),
            Exception::class,
            'password should have one uppercase letter at least'
        );
        throw_if(
            !preg_match('/[a-z]/', $password),
            Exception::class,
            'password should have one lowercase letter at least'
        );
        throw_if(
            !preg_match('/[0-9]/', $password),
            Exception::class,
            'password should have one number at least'
        );
    }
}