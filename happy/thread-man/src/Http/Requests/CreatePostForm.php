<?php

namespace Happy\ThreadMan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

use Happy\ThreadMan\Reply;
use Happy\ThreadMan\Rules\SpamFree;
use Happy\ThreadMan\Exceptions\ThrottleException;


class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply());
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('You are repling too frequently');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', new SpamFree]
        ];
    }
}
