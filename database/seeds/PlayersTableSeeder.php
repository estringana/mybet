<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = \App\Models\Team::all();

        foreach ($teams as $team) {
            $players = $match = factory(App\Models\Player::class,24)
                ->create(
                    [ 'team_id' => $team->id ]
                );
        }
    }
}
