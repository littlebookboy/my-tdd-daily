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
     * @var array $trueWhenPasswordInvalid
     */
    private $trueWhenPasswordInvalid;

    /**
     * PasswordVerificationService constructor.
     * @param $password
     */
    public function __construct($password)
    {
        $this->password = $password;
        $this->trueWhenPasswordInvalid = [
            'password_should_not_null' => is_null($this->password),
            'password_should_large_than_8_chars' => strlen($this->password) < 8,
            'password_should_have_one_uppercase_letter_at_least' => !preg_match('/[A-Z]/', $this->password),
            'password_should_have_one_lowercase_letter_at_least' => !preg_match('/[a-z]/', $this->password),
            'password_should_have_one_number_at_least' => !preg_match('/[0-9]/', $this->password),
        ];
    }

    public function verify()
    {
        throw_if(
            $this->trueWhenPasswordInvalid['password_should_not_null'],
            Exception::class,
            'password should not be null'
        );

        throw_if(
            $this->trueWhenPasswordInvalid['password_should_large_than_8_chars'],
            Exception::class,
            'password should be larger than 8 chars'
        );

        throw_if(
            $this->trueWhenPasswordInvalid['password_should_have_one_uppercase_letter_at_least'],
            Exception::class,
            'password should have one uppercase letter at least'
        );

        throw_if(
            $this->trueWhenPasswordInvalid['password_should_have_one_lowercase_letter_at_least'],
            Exception::class,
            'password should have one lowercase letter at least'
        );

        throw_if(
            $this->trueWhenPasswordInvalid['password_should_have_one_number_at_least'],
            Exception::class,
            'password should have one number at least'
        );
    }

    /**
     * Add feature: Password is OK if at least three of the previous conditions is true
     *
     * @return bool
     */
    public function isPasswordOK(): bool
    {
        $validNumber = 0;

        foreach ($this->trueWhenPasswordInvalid as $isInvalid) {
            $validNumber += (!$isInvalid) ? 1 : 0;
        }

        return $validNumber >= 3;
    }
}