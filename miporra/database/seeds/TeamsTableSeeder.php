<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TeamsTableSeeder extends Seeder
{
    private function codify($name){
        return strtolower(str_replace(' ','_',$name));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
	'Albania',
	'Austria',
	'Belgium',
	'Croatia',
	'Czech Republic',
	'England',
	'France',
	'Germany',
	'Hungary',
	'Iceland',
	'Italy',
	'Northern Ireland',
	'Poland',
	'Portugal',
	'Republic of Ireland',
	'Romania',
	'Russia',
	'Slovakia',
	'Spain',
	'Sweden',
	'Switzerland',
	'Turkey',
	'Ukraine',
	'Wales'
        ];

        foreach ($teams as $team) {
        	DB::table('teams')->insert([
                'name' => $team,
                'code' => $this->codify($team),
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
