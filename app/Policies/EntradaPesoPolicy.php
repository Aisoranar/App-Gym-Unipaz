<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EntradaPeso;

class EntradaPesoPolicy
{
    public function view(User $user, EntradaPeso $entrada)
    {
        return $user->id === $entrada->user_id;
    }

    public function update(User $user, EntradaPeso $entrada)
    {
        return $user->id === $entrada->user_id;
    }

    public function delete(User $user, EntradaPeso $entrada)
    {
        return $user->id === $entrada->user_id;
    }
}
