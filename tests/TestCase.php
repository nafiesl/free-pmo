<?php

namespace Tests;

use App\Entities\Users\Role;
use App\Entities\Users\User;
use Tests\Traits\DatabaseMigrateSeeds;

class TestCase extends \Laravel\BrowserKitTesting\TestCase
{
    use DatabaseMigrateSeeds;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        \Hash::setRounds(5);

        return $app;
    }

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
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        return $user;
    }
}
