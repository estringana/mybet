<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlayerBetsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player_0' => 'required',
            'player_1' => 'required',
            'player_2' => 'required',
            'player_3' => 'required',
            'player_4' => 'required',
            'player_5' => 'required',
            'player_6' => 'required',
            'player_7' => 'required',
        ];
    }
}
