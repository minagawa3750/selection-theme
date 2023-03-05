<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodolistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('todolists')->insert(
        [
          [
            'name' => 'テスト1',
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'name' => 'テスト2',
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'name' => 'テスト3',
            'created_at' => now(),
            'updated_at' => now(),
          ],
        ]
      );
    }
}
