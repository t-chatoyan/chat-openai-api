<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::create([
            'name' => 'Познакомь Искусственный Интеллект MSU с собой.',
        ]);
        Categories::create([
            'name' => 'Финансы',
        ]);
        Categories::create([
            'name' => 'Признание',
        ]);
        Categories::create([
            'name' => 'Клиенты',
        ]);
        Categories::create([
            'name' => 'Партнеры',
        ]);
        Categories::create([
            'name' => 'Семья',
        ]);
        Categories::create([
            'name' => 'Карьера',
        ]);
        Categories::create([
            'name' => 'Профессия',
        ]);
        Categories::create([
            'name' => 'Создание ценности',
        ]);
        Categories::create([
            'name' => 'Бизнес',
        ]);
        Categories::create([
            'name' => 'Инновации',
        ]);
        Categories::create([
            'name' => 'Интеллект',
        ]);
        Categories::create([
            'name' => 'Навыки',
        ]);
        Categories::create([
            'name' => 'Знания',
        ]);
        Categories::create([
            'name' => 'Питание',
        ]);
        Categories::create([
            'name' => 'Спорт',
        ]);
        Categories::create([
            'name' => 'Стресс',
        ]);
        Categories::create([
            'name' => 'Отдых',
        ]);
        Categories::create([
            'name' => 'Обновление инструкции',
        ]);
    }
}
