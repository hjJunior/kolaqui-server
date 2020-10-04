<?php

namespace App\Policies;

use App\UploadedFile;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadedFilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\UploadedFile  $uploadedFile
     * @return mixed
     */
    public function view(User $user, UploadedFile $uploadedFile)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\UploadedFile  $uploadedFile
     * @return mixed
     */
    public function update(User $user, UploadedFile $uploadedFile)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\UploadedFile  $uploadedFile
     * @return mixed
     */
    public function delete(User $user, UploadedFile $uploadedFile)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\UploadedFile  $uploadedFile
     * @return mixed
     */
    public function restore(User $user, UploadedFile $uploadedFile)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\UploadedFile  $uploadedFile
     * @return mixed
     */
    public function forceDelete(User $user, UploadedFile $uploadedFile)
    {
        return false;
    }
}
