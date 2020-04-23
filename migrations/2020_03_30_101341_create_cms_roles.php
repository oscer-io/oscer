<?php

use Oscer\Cms\Core\Users\Models\Role;
use Illuminate\Database\Migrations\Migration;

class CreateCmsRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create(['name' => Role::SUPER_ADMIN_ROLE]);
    }
}
