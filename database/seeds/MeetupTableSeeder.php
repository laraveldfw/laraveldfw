<?php

use Illuminate\Database\Seeder;
use App\MeetupApiHelper;
class MeetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $helper = new MeetupApiHelper();
        $helper->checkMeetupForUpdates();
    }
}
