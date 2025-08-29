<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Encontra todos os usuários que têm function_id igual a 2
        $nonAdminUsers = User::where('function_id', 2)->pluck('user_id');

        // Garante que há usuários para associar os produtos
        if ($nonAdminUsers->isEmpty()) {
            echo "Nenhum usuário com function_id 2 encontrado para associar produtos.";
            return;
        }

        // Cria exatamente 36 produtos e associa cada um a um usuário aleatório da lista
        Product::factory(36)->create([
            'seller_id' => function () use ($nonAdminUsers) {
                return $nonAdminUsers->random();
            },
        ]);
    }
}