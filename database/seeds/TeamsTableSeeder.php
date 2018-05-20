<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TeamsTableSeeder extends Seeder
{
    private function codify($name){
        return strtolower(str_replace(' ','',$name));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
	        ['id' => 1, 'name' => 'Russia', 'code' => 'ru'],
            ['id' => 2, 'name' => 'Saudi Arabia', 'code' => 'sa'],
            ['id' => 3, 'name' => 'Egypt', 'code' => 'eg'],
            ['id' => 4, 'name' => 'Uruguay', 'code' => 'uy'],
            ['id' => 5, 'name' => 'Portugal', 'code' => 'pt'],
            ['id' => 6, 'name' => 'Spain', 'code' => 'es'],
            ['id' => 7, 'name' => 'Morocco', 'code' => 'ma'],
            ['id' => 8, 'name' => 'Iran', 'code' => 'ir'],
            ['id' => 9, 'name' => 'France', 'code' => 'fr'],
            ['id' => 10, 'name' => 'Australia', 'code' => 'au'],
            ['id' => 11, 'name' => 'Peru', 'code' => 'pe'],
            ['id' => 12, 'name' => 'Denmark', 'code' => 'dk'],
            ['id' => 13, 'name' => 'Argentina', 'code' => 'ar'],
            ['id' => 14, 'name' => 'Iceland', 'code' => 'is'],
            ['id' => 15, 'name' => 'Croatia', 'code' => 'hr'],
            ['id' => 16, 'name' => 'Nigeria', 'code' => 'ng'],
            ['id' => 17, 'name' => 'Brazil', 'code' => 'br'],
            ['id' => 18, 'name' => 'Switzerland', 'code' => 'ch'],
            ['id' => 19, 'name' => 'Costa Rica', 'code' => 'cr'],
            ['id' => 20, 'name' => 'Serbia', 'code' => 'rs'],
            ['id' => 21, 'name' => 'Germany', 'code' => 'de'],
            ['id' => 22, 'name' => 'Mexico', 'code' => 'mx'],
            ['id' => 23, 'name' => 'Sweden', 'code' => 'se'],
            ['id' => 24, 'name' => 'South Korea', 'code' => 'kr'],
            ['id' => 25, 'name' => 'Belgium', 'code' => 'be'],
            ['id' => 26, 'name' => 'Panama', 'code' => 'pa'],
            ['id' => 27, 'name' => 'Tunisia', 'code' => 'tn'],
            ['id' => 28, 'name' => 'England', 'code' => 'england'],
            ['id' => 29, 'name' => 'Poland', 'code' => 'pl'],
            ['id' => 30, 'name' => 'Senegal', 'code' => 'sn'],
            ['id' => 31, 'name' => 'Colombia', 'code' => 'co'],
            ['id' => 32, 'name' => 'Japan', 'code' => 'jp'],
        ];

        foreach ($teams as $team) {
        	DB::table('teams')->insert([
                'id' => $team['id'],
                'name' => $team['name'],
                'code' => $this->codify($team['name']),
                'short_code' => $team['code'],
                'championship_id' => 
                    App\Models\Championship::where('code', '=', 'worldcup2018')
                    ->firstOrFail()
                    ->id,
    	   'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    	   'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	]);
        }
    }
}
