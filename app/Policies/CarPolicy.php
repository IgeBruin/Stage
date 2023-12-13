<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Car;

class CarPolicy
{
    public function update(User $user, Car $car)
    {
        return $user->id === $car->user_id;
    }

    public function delete(User $user, Car $car)
    {
        return $user->id === $car->user_id;
    }
}
