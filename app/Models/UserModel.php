<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // protected $DBGroup = 'mbel';
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'name', 
        'email',
        'password', 
        'status', 
        'token'

    ];

    public function displayUsers()
    {
        return $this->findAll();
    }

    public function insertUser($data)
    {
        $this->save($data);
    }

    public function getUser($data)
    {
        $result = $this->where('email', $data)->first();
        return $result;
    }

    public function updateUser($data,$token)
    {
        $this->set($data)
        ->where('token',$token)
        ->update();
       //echo($this->getLastQuery()->getQuery());
    }
}