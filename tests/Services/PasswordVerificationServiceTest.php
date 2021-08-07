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
        $this->expectException(Exception::class);
        $passwordVerificationService = new PasswordVerificationService('AA34567');
        $this->assertTrue($passwordVerificationService->verify());
    }

    public function test_should_get_false_when_pass_less_than_three_rules()
    {
        // not null
        // at least one uppercase char
        $this->expectException(Exception::class);
        $passwordVerificationService = new PasswordVerificationService('AABBCCD');
        $this->assertFalse($passwordVerificationService->verify());
    }

    /**
     * @param $password
     * @dataProvider forceCheckRulesProvider
     * @throws \Throwable
     */
    public function test_should_get_false_when_force_check_rules($password)
    {
        $this->expectException(Exception::class);
        // 1. password should be larger than 8 chars
        // 4. password should have one lowercase letter at least
        $passwordVerificationService = new PasswordVerificationService($password);
        $this->assertFalse($passwordVerificationService->verify());
    }

    public function forceCheckRulesProvider()
    {
        return [
            // password should be larger than 8 chars
            ['Ab123'],
            // password should have one lowercase letter at least
            ['AA123'],
        ];
    }

    private function givenPassword($password): void
    {
        $passwordVerificationService = new PasswordVerificationService($password);
        $passwordVerificationService->verify();
    }
}
