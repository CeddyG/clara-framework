<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;

class RoleController extends ContentManagerController
{
    public function __construct(Role $role)
    {
        $this->path         = 'admin.roles';
        $this->pathRedirect = 'admin/roles';
        $this->name         = 'Roles';       
        
        $this->model        = $role;
        $this->datatable    = \App\DataTables\RoleDataTable::class;
        $this->formRequest  = \App\Http\Requests\RoleRequest::class;
    }
}
