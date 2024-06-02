<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
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
    
    public function all($keys = null)
    {
        $attributes = parent::all($keys);
        
        if (($this->method() == 'PUT' || $this->method() == 'PATCH') && $attributes['password'] == '') {
            unset($attributes['password']);
        }
        
        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }
        
        if (isset($attributes['permissions'])) {
            $permissions = [];
            
            foreach ($attributes['permissions'] as $permission) {
                $permissions[$permission] = true;
            }
            
            $attributes['permissions'] = $permissions;
        } else {
            $attributes['permissions'] = [];
        }
        
        return $attributes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'name'      => 'required|max:255|string',
                    'email'     => 'required|max:255|email|unique:users',
                    'password'  => 'required|max:255|string'
                ];
            }
            
            case 'PUT':
            case 'PATCH':
            {
                $user = User::find($this->user);
                
                return [
                    'name'      => 'required|max:255|string',
                    'email'     => 'required|max:255|email|unique:users,email,'.$user->id,
                    'password'  => 'max:255'
                ];
            }
            
            default:break;
        }
    }
}
