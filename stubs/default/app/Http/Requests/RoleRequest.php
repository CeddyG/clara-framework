<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'slug' => 'required|max:255|string'
        ];
    }
}
