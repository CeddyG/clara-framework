<?php

namespace App\Models\Traits;

use App\Models\Role;

trait Permission
{
    public function initializePermission()
    {
        $this->fillable[]   = 'permissions';
        $this->casts        = $this->casts + ['permissions' => 'array'];
    }
    
    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}
