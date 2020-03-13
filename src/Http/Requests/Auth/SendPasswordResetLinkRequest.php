<?php


namespace Bambamboole\LaravelCms\Http\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendPasswordResetLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $existsRule = Rule::exists(config('cms.database_connection').'.users', 'email');

        return [
            'email' => ['required', 'email', $existsRule],
        ];
    }
}
