<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@usap.edu'],
            [
                'name' => 'Marco Alemán Watters',
                'password' => '123456',
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'usuario@usap.edu'],
            [
                'name' => 'Estudiante USAP',
                'password' => '123456',
                'role' => 'user',
            ]
        );

        if (Post::count() === 0) {
            Post::create([
                'title' => 'Admisiones',
                'content' => 'Información sobre el proceso de admisiones en la universidad.',
                'author' => 'Admisiones',
                'category' => 'Admisiones',
            ]);
        }
    }
}
