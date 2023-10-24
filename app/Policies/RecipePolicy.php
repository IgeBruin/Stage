<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return Auth::check();
    }

    public function update(User $user, Recipe $recipe)
    {
        $users = $recipe->users;
        return $users->contains('id', $user->id);
    }

    public function delete(User $user, Recipe $recipe)
    {
        $users = $recipe->users;
        return $users->contains('id', $user->id);
    }

    public function isAdmin(User $user)
    {
        return $user->isAdmin == 1; //voor testen 1 is admin en ige bruin heeft waarde 1, werknemer en bezoekr hebben waarde 0
    }
}
