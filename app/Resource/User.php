<?php

namespace App\Resource;

class User extends Resource {
  public function element($user)
  {
    return [
      'id' => (int) $user->id,
      'username' => $user->username,
      'email' => $user->email,
      'role' => is_null($user->role) ? '_default' : $user->role,
      'avatar' => is_null($user->avatar) ? null : 'storage/avatars/' . $user->avatar
    ];
  }
}