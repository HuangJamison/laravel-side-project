<?php
namespace Tests\Database;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class TableCreator
{
    public function create(string $table): void
    {
        $function = sprintf("create_%s", strtolower($table));

        if (!method_exists($this, $function)) {
            throw new \Exception('method not exists: ' . $function);
        }

        $this->$function();
    }

    private function create_user_verification_reasons()
    {
        Manager::schema()->create('user_verification_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }
}
