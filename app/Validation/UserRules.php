<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{
    public function validate_user(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('email',$data['email'])->first();

        if(!$user)
            return false;

        return password_verify($data['password'],$user['password']);
    }

    public function validate_user_status(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $status = $model->select('status')->where('email',$data['email'])->get();
        $row = $status->getRowArray();

        if (isset($row))
        {
            if($row['status'] == 0){
                return false;
            }
        }
        
    }
}