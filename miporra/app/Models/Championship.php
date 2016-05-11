<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Championship extends Model
{
    public function inProgress()
    {
    	return Carbon::now() >= $this->start_date && Carbon::now() <= $this->end_date;
    }
}
