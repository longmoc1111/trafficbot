<?php

namespace Database\Seeders;

use App\Models\ChatCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $Categories = [
            ["CategoryID" => 1, "CategoryName" => "PDF"],
            ["CategoryID" => 2, "CategoryName" => "URL"]
        ];
        foreach($Categories as $category){
            ChatCategory::create($category);
        }
    }
}
