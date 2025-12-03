<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Joke;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        // Define jokes and their categories
        $jokes = [
            [
                'title' => "What is a pirate’s favourite element?",
                'content' => "Arrrrrrrrgon",
                'categories' => ['Science', 'Pirate'],
            ],
            [
                'title' => "Why did the amoeba fail the Maths class?",
                'content' => "Because it multiplied by dividing.",
                'categories' => ['Science'],
            ],
            [
                'title' => "Why did the physicist break up with the biologist?",
                'content' => "Because there was no chemistry.",
                'categories' => ['Science'],
            ],
            [
                'title' => "What did the mum say to their messy kid?",
                'content' => "I have a black belt in laundry.",
                'categories' => ['Mum', 'Kids'],
            ],
            [
                'title' => "What did the toddler say to the tired mum?",
                'content' => "Naptime for you, not me.",
                'categories' => ['Mum', 'Kids'],
            ],
            [
                'title' => "What did the ocean say to the pirate?",
                'content' => "Nothing. It just waved.",
                'categories' => ['Pirate'],
            ],
            [
                'title' => "What is a pirate’s least favourite vegetable?",
                'content' => "Leeks.",
                'categories' => ['Food', 'Pirate'],
            ],
            [
                'title' => "I used to be a baker… but I could not make enough dough.",
                'content' => "",
                'categories' => ['Food', 'Puns'],
            ],
            [
                'title' => "What types of maths are pirates best at?",
                'content' => "Algebra, because they are good at finding X.",
                'categories' => ['Pirate', 'Maths'],
            ],
        ];

        // Loop through jokes and insert
        foreach ($jokes as $j) {
            $joke = Joke::create([
                'user_id' => $user->id,
                'title' => $j['title'],
                'content' => $j['content'],
            ]);

            // Attach categories
            $categoryIds = Category::whereIn('title', $j['categories'])->pluck('id')->toArray();
            $joke->categories()->sync($categoryIds);
        }
    }
}
