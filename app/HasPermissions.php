<?php

namespace App;

trait HasPermissions
{
    public function hasRole($role) {
        return $this->roles->contains('slug', $role);
    }

    public function hasPermission($permission) {
        return $this->roles->flatMap->permissions->contains('slug', $permission);
    }
}
