<?php


namespace App\Services;


use Exception;

class PasswordVerificationService
{
    /**
     * @var string $password
     */
    private $password;

    /**
     * PasswordVerificationService constructor.
     * @param $password
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    public function verify()
    {
        throw_if(is_null($this->password), Exception::class, 'password should not be null');
        throw_if(strlen($this->password) < 8, Exception::class, 'password should be larger than 8 chars');
        throw_if(
            !preg_match('/[A-Z]/', $this->password),
            Exception::class,
            'password should have one uppercase letter at least'
        );
        throw_if(
            !preg_match('/[a-z]/', $this->password),
            Exception::class,
            'password should have one lowercase letter at least'
        );
        throw_if(
            !preg_match('/[0-9]/', $this->password),
            Exception::class,
            'password should have one number at least'
        );
    }
}