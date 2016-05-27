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
	['name' => 'Albania', 'code' => 'al'],
	['name' => 'Austria', 'code' => 'at'],
	['name' => 'Belgium', 'code' => 'be'],
	['name' => 'Croatia', 'code' => 'hr'],
	['name' => 'Czech Republic', 'code' => 'cz'],
	['name' => 'England', 'code' => 'england'],
	['name' => 'France', 'code' => 'fr'],
	['name' => 'Germany', 'code' => 'de'],
	['name' => 'Hungary', 'code' => 'hu'],
	['name' => 'Iceland', 'code' => 'is'],
	['name' => 'Italy', 'code' => 'it'],
	['name' => 'Northern Ireland', 'code' => 'gg'],
	['name' => 'Poland', 'code' => 'pl'],
	['name' => 'Portugal', 'code' => 'pt'],
	['name' => 'Republic of Ireland', 'code' => 'ie'],
	['name' => 'Romania', 'code' => 'ro'],
	['name' => 'Russia', 'code' => 'ru'],
	['name' => 'Slovakia', 'code' => 'sk'],
	['name' => 'Spain', 'code' => 'es'],
	['name' => 'Sweden', 'code' => 'se'],
	['name' => 'Switzerland', 'code' => 'ch'],
	['name' => 'Turkey', 'code' => 'tr'],
	['name' => 'Ukraine', 'code' => 'ua'],
	['name' => 'Wales', 'code' => 'wales']
        ];

        foreach ($teams as $team) {
        	DB::table('teams')->insert([
                'name' => $team['name'],
                'code' => $this->codify($team['name']),
                'short_code' => $team['code'],
                'championship_id' => 
                    App\Models\Championship::where('code', '=', 'euro2016')
                    ->firstOrFail()
                    ->id,
    	   'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    	   'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
	]);
        }
    }
}
