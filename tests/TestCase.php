<?php

namespace Tests;

use App\Entities\Users\User;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function adminUserSigningIn($userDataOverrides = [])
    {
        $user = $this->createUser('admin', $userDataOverrides);
        $this->actingAs($user);

        return $user;
    }

    protected function userSigningIn($userDataOverrides = [])
    {
        $user = $this->createUser('worker', $userDataOverrides);
        $this->actingAs($user);

        return $user;
    }

    protected function createUser($role = 'admin', $userDataOverrides = [])
    {
        $user = factory(User::class)->create($userDataOverrides);
        $user->assignRole($role);

        return $user;
    }

    protected function assertFileExistsThenDelete($filePath, $message = '')
    {
        $this->assertTrue(file_exists($filePath), $message);

        unlink($filePath);
        $this->assertFalse(file_exists($filePath));
    }
}
