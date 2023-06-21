<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RolesAndPermissionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('message edit')){
            return true;
        }
        return false;
    }
    protected function failedAuthorization(){
        throw new \Illuminate\Auth\Access\AuthorizationException(__('auth.admin only Unauthorised'));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role' => ['required', 'unique:roles,name,' . $this->id, 'max:60'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ];
    }
}
