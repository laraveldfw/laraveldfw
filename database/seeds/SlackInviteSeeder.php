<?php

use Illuminate\Database\Seeder;

class SlackInviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SlackInvite::class, 30)->create();
    }
}
