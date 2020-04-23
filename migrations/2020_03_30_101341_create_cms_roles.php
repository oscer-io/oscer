<?php

use Illuminate\Database\Migrations\Migration;
use Oscer\Cms\Core\Users\Models\Role;

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
