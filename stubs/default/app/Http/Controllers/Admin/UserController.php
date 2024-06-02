<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

class UserController extends ContentManagerController
{
    public function __construct(User $user)
    {
        $this->path         = 'admin.users';
        $this->pathRedirect = 'admin/users';
        $this->name         = 'Users';      
        
        $this->model        = $user;
        $this->datatable    = \App\DataTables\UserDataTable::class;
        $this->formRequest  = \App\Http\Requests\UserRequest::class;
    }
}
