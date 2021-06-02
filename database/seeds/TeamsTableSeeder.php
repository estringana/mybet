<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TeamsTableSeeder extends Seeder
{
    private function codify($name)
    {
        return strtolower(str_replace(' ', '', $name));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['id' => 1, 'name' => 'Finland', 'code' => 'FI'],
            ['id' => 2, 'name' => 'Italy', 'code' => 'IT'],
            ['id' => 3, 'name' => 'Switzerland', 'code' => 'CH'],
            ['id' => 4, 'name' => 'North Macedonia', 'code' => 'MK'],
            ['id' => 5, 'name' => 'Slovakia', 'code' => 'SK'],
            ['id' => 6, 'name' => 'Ukraine', 'code' => 'UA'],
            ['id' => 7, 'name' => 'Sweden', 'code' => 'SE'],
            ['id' => 8, 'name' => 'Portugal', 'code' => 'PT'],
            ['id' => 9, 'name' => 'Czech Republic', 'code' => 'CZ'],
            ['id' => 10, 'name' => 'Germany', 'code' => 'DE'],
            ['id' => 11, 'name' => 'Croatia', 'code' => 'HR'],
            ['id' => 12, 'name' => 'Russia', 'code' => 'RU'],
            ['id' => 13, 'name' => 'Belgium', 'code' => 'BE'],
            ['id' => 14, 'name' => 'Netherlands', 'code' => 'NL'],
            ['id' => 15, 'name' => 'Hungary', 'code' => 'HU'],
            ['id' => 16, 'name' => 'France', 'code' => 'FR'],
            ['id' => 17, 'name' => 'Wales', 'code' => 'WLS'],
            ['id' => 18, 'name' => 'Denmark', 'code' => 'DK'],
            ['id' => 19, 'name' => 'England', 'code' => 'EN'],
            ['id' => 20, 'name' => 'Turkey', 'code' => 'TR'],
            ['id' => 21, 'name' => 'Poland', 'code' => 'PL'],
            ['id' => 22, 'name' => 'Spain', 'code' => 'ES'],
            ['id' => 23, 'name' => 'Austria', 'code' => 'AT'],
            ['id' => 24, 'name' => 'Scotland', 'code' => 'SCT'],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->insert([
                'id' => $team['id'],
                'name' => $team['name'],
                'code' => $this->codify($team['name']),
                'short_code' => $team['code'],
                'championship_id' =>
                    App\Models\Championship::where('code', '=', 'eurocup2020')
                    ->firstOrFail()
                    ->id,
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ]);
        }
    }
}
