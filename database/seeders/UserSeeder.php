<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminFunction = DB::table('functions')->where('name', 'Administrador')->first();
        $userFunction = DB::table('functions')->where('name', 'Usuário')->first();

        if($adminFunction && $userFunction) {
            User::factory(9)->create([
                'function_id' => $adminFunction->function_id,
            ]);

            User::factory(18)->create([
                'function_id' => $userFunction->function_id,
            ]);
        }
    }
}
