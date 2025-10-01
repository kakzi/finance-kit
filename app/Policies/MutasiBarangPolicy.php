<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MutasiBarang;
use Illuminate\Auth\Access\HandlesAuthorization;

class MutasiBarangPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_mutasi::barang');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MutasiBarang $mutasiBarang): bool
    {
        return $user->can('view_mutasi::barang');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_mutasi::barang');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MutasiBarang $mutasiBarang): bool
    {
        return $user->can('update_mutasi::barang');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MutasiBarang $mutasiBarang): bool
    {
        return $user->can('delete_mutasi::barang');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_mutasi::barang');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MutasiBarang $mutasiBarang): bool
    {
        return $user->can('force_delete_mutasi::barang');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_mutasi::barang');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MutasiBarang $mutasiBarang): bool
    {
        return $user->can('restore_mutasi::barang');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_mutasi::barang');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MutasiBarang $mutasiBarang): bool
    {
        return $user->can('replicate_mutasi::barang');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_mutasi::barang');
    }
}
