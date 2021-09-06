<?php

namespace Database\Seeders;

use App\Models\Note;
use Database\Factories\NoteFactory;
use Illuminate\Database\Seeder;

class NoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Note::factory(5)->create();
    }
}
