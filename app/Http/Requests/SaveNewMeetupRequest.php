<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveNewMeetupRequest extends Request
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
        $st = 'sometimes|required|string|max:255';
        return [
            'start_time' => 'required|date',
            'online' => 'required|boolean',
            'location_name' => $st,
            'location_address' => $st,
            'location_phone' => $st,
            'location_url' => 'sometimes|required|url',
            'location_lat' => 'sometimes|required|number|min:-90|max:90',
            'location_lng' => 'sometimes|required|number|min:-180|max:180',
            'talk' => 'required|string|max:255',
            'speaker' => $st,
            'speaker_img' => 'sometimes|required|url',
            'speaker_url' => 'sometimes|required|url',
            'additional_info' => 'sometimes|required|string',
        ];
    }
}
