<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['username', 'email', 'hashed_password', 'created_at'];

    public function findUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function registerUser($data)
    {
        return $this->insert($data);
    }

    public function verifyUser($email, $password)
    {
        $user = $this->findUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user['hashed_password'])) {
                return $user;
            }
        }
        return null;
    }

    public function getLoggedInUser()
    {
        if (!session()->has('loggedUser')) return null;
        return $this->where('user_id', session()->get('loggedUser'))->first();
    }

    public function updateUser($userId, $data)
    {
        return $this->update($userId, $data);
    }
}
