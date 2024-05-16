<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $languages = [
            "Python",
            "Java",
            "JavaScript",
            "C++",
            "C#",
            "Ruby",
            "PHP",
            "Swift",
            "Go",
            "Kotlin",
            "Rust",
            "Scala",
            "Objective-C",
            "TypeScript",
            "Perl",
            "R",
            "Haskell",
            "Lua",
            "SQL",
            "Assembly",
            "HTML",
            "CSS",
            "Bash",
            "Clojure",
            "Dart",
            "Groovy",
            "Matlab",
            "Visual Basic",
            "Pascal",
            "Fortran"
        ];

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
        ]);



        foreach ($languages as $language) {
            Category::factory()->create(['title' => $language]);
        }
    }
}
