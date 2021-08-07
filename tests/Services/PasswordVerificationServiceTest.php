<?php

namespace Tests\Services;

use App\Services\PasswordVerificationService;
use Exception;
use PHPUnit\Framework\TestCase;

class PasswordVerificationServiceTest extends TestCase
{
    public function test_throw_exception_if_password_less_than_8_chars()
    {
        $this->expectExceptionMessage('password should be larger than 8 chars');
        $this->givenPassword('1234567');
    }

    public function test_throw_exception_if_password_is_null()
    {
        $this->expectExceptionMessage('password should not be null');
        $this->givenPassword(null);
    }

    public function test_throw_exception_if_password_without_any_upper_case_char()
    {
        $this->expectExceptionMessage('password should have one uppercase letter at least');
        $this->givenPassword('a2345678');
    }

    public function test_throw_exception_if_password_without_any_lower_case_char()
    {
        $this->expectExceptionMessage('password should have one lowercase letter at least');
        $this->givenPassword('A2345678');
    }

    public function test_throw_exception_if_password_without_any_number()
    {
        $this->expectExceptionMessage('password should have one number at least');
        $this->givenPassword('AABBccdd');
    }

    public function test_should_get_true_when_pass_at_least_three_rules()
    {
        // not null
        // at least one uppercase char
        // at least one lowercase char
        try {
            $passwordVerificationService = new PasswordVerificationService('AA34567');
            $passwordVerificationService->verify();
        } catch (Exception $e) {
            $this->assertTrue($passwordVerificationService->isPasswordOK());
        }
    }

    public function test_should_get_false_when_pass_less_than_three_rules()
    {
        // not null
        // at least one uppercase char
        try {
            $passwordVerificationService = new PasswordVerificationService('AABBCCD');
            $passwordVerificationService->verify();
        } catch (Exception $e) {
            $this->assertFalse($passwordVerificationService->isPasswordOK());
        }
    }

    private function givenPassword($password): void
    {
        $passwordVerificationService = new PasswordVerificationService($password);
        $passwordVerificationService->verify();
    }
}
