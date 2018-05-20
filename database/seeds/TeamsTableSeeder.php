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
	['id' => 1,'name' => 'Albania', 'code' => 'al'],
	['id' => 2,'name' => 'Austria', 'code' => 'at'],
	['id' => 3,'name' => 'Belgium', 'code' => 'be'],
	['id' => 4,'name' => 'Croatia', 'code' => 'hr'],
	['id' => 5,'name' => 'Czech Republic', 'code' => 'cz'],
	['id' => 6,'name' => 'England', 'code' => 'england'],
	['id' => 7,'name' => 'France', 'code' => 'fr'],
	['id' => 8,'name' => 'Germany', 'code' => 'de'],
	['id' => 9,'name' => 'Hungary', 'code' => 'hu'],
	['id' => 10,'name' => 'Iceland', 'code' => 'is'],
	['id' => 11,'name' => 'Italy', 'code' => 'it'],
	['id' => 12,'name' => 'Northern Ireland', 'code' => 'gg'],
	['id' => 13,'name' => 'Poland', 'code' => 'pl'],
	['id' => 14,'name' => 'Portugal', 'code' => 'pt'],
	['id' => 15,'name' => 'Republic of Ireland', 'code' => 'ie'],
	['id' => 16,'name' => 'Romania', 'code' => 'ro'],
	['id' => 17,'name' => 'Russia', 'code' => 'ru'],
	['id' => 18,'name' => 'Slovakia', 'code' => 'sk'],
	['id' => 19,'name' => 'Spain', 'code' => 'es'],
	['id' => 20,'name' => 'Sweden', 'code' => 'se'],
	['id' => 21,'name' => 'Switzerland', 'code' => 'ch'],
	['id' => 22,'name' => 'Turkey', 'code' => 'tr'],
	['id' => 23,'name' => 'Ukraine', 'code' => 'ua'],
	['id' => 24,'name' => 'Wales', 'code' => 'wales']
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
