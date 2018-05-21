<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players = [
  // ["name" => "Manuel Neuer", "team_id" => 8],
        ];

         foreach ($players as $player) {
            DB::table('players')->insert([
                'name' => $player['name'],
                'team_id' => $player['team_id'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
