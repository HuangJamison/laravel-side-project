<?php 
    namespace App\Services;


class UnitTestService
{
    public function isTest(array $data): bool
    {
        return $data['is_test'];
    }
}