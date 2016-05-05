<?php

use Illuminate\Database\Seeder;

class MeetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Meetup::class, 20)->create();
    }
}
