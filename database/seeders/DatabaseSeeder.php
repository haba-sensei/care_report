<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        if (is_dir(public_path() . '/storage')) {
            rmdir(public_path() . '/storage');
            Artisan::call('storage:link');
        }


    }
}
