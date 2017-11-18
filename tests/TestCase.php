<?php

namespace Tests;

use App\Entities\Users\User;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
use Tests\Traits\DatabaseMigrateSeeds;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrateSeeds;

    protected function setUpTraits()
    {
        parent::setUpTraits();
        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[DatabaseMigrateSeeds::class])) {
            $this->runDatabaseMigrateSeeds();
        }
    }

    protected function adminUserSigningIn()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        return $user;
    }

    protected function userSigningIn()
    {
        $user = $this->createUser('worker');
        $this->actingAs($user);

        return $user;
    }

    protected function createUser($role = 'admin')
    {
        $user = factory(User::class)->create();
        $user->assignRole($role);
        return $user;
    }

    protected function assertFileExistsThenDelete($filePath, $message = null)
    {
        $this->assertTrue(file_exists($filePath), $message);

        unlink($filePath);
        $this->assertFalse(file_exists($filePath));
    }
}
