<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JournalToAuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationships = [];
        for ($i = 0; $i < 30; $i++) {
            $relationship['author_id'] = rand(1, 10);
            $relationship['journal_id'] = rand(1, 50);
            $relationships[] = $relationship;
        }

        DB::table('journal_to_authors')->insert($relationships);
    }
}
