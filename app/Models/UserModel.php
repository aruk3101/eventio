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
}
