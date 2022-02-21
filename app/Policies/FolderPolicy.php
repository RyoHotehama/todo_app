<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * フォルダの閲覧権限
     * @param User $user
     * @param Todo $folder
     * @return bool
     */
    public function view(User $user, Todo $folder)
    {
        return $user->id === $folder->user_id;
    }
}
