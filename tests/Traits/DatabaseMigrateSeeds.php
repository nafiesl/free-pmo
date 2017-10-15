<?php

namespace Tests\Traits;

use Illuminate\Contracts\Console\Kernel;

trait DatabaseMigrateSeeds
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrateSeeds()
    {
        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->app[Kernel::class]->setArtisan(null);
    }
}
