<?php

namespace Spatie\DatabaseCleanup\Test;

use Spatie\DatabaseCleanup\Test\Models\DummyItem;
use Illuminate\Contracts\Console\Kernel;

class DatabaseCleanupTest extends TestCase
{
    /** @test */
    public function it_can_delete_expired_records_from_a_database()
    {
        DummyItem::cleanUpModel(DummyItem::query())->delete();

        $this->assertTrue(DummyItem::count() === 10);
    }

    /** @test */
    public function it_can_cleanup_a_database_running_command_with_models_config()
    {
        $this->app['config']->set('laravel-database-cleanup',
            ['models' => [DummyItem::class],
            'directories' => [__DIR__.'/Models', __DIR__.'/Models2'], ]);

        $this->app->make(Kernel::class)->call('databaseCleanup:clean');

        $this->assertTrue(DummyItem::count() === 10);
    }

    /** @test */
    public function it_can_cleanup_a_database_running_command_with_directories_config()
    {
        $this->app['config']->set('laravel-database-cleanup',
            ['models' => [DummyItem::class], 'directories' => [__DIR__.'/Models', __DIR__.'/Models2']]);

        $this->app->make(Kernel::class)->call('databaseCleanup:clean');

        $this->assertTrue(DummyItem::count() === 10);
    }
}
