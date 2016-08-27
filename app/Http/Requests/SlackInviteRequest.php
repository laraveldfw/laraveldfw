<?php

namespace App\Http\Requests;

use Guzzle\Http\Message\Response;
use Illuminate\Foundation\Http\FormRequest;
use App\SlackHelper;
use Input;
class SlackInviteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $helper = new SlackHelper();
        if ($helper->emailAndNameAreUniqueToTeam(Input::get('email'), Input::get('name'))) {
            return true;
        }
        return false;
    }

    public function forbiddenResponse()
    {
        return response()->json([
            'userExists' => true,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required|string|max:50',
        ];
    }
}
