<?php
namespace Tests\Database;

use Illuminate\Database\Capsule\Manager;

class EloquentConnection
{
    public static function addConnection()
    {
        $capsule = new Manager;

        $capsule->addConnection([
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'    => '',
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();
        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        return $capsule;
    }
}
