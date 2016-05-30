<?php

use Illuminate\Database\Seeder;

class RoundsTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $round = App\Models\Round::where('name','=','Group Stage')->firstOrFail();

        $teams = App\Models\Team::all();

        foreach ($teams as $team) {
            $round->addTeam($team);
        }
    }
}
