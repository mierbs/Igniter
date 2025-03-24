<?php

namespace App\Controllers;
use App\Models\UserModel;

class AccountController extends BaseController
{
    
    //Display User
    public function user()
    {
        $model = model(UserModel::class);
        $data['user_list'] = $model->displayUsers();
        $data['title']= 'Accounts';
        $data['sex']= 'Male';
        $data['main_content'] = 'userView';

        return view ('innerpages/template', $data);
    }

    //Register Page
    public function register()
    {
        helper(['form']);
        $data = [];
        $data['title']= 'Register';
        $data['main_content'] = 'registerView';
        return view ('innerpages/template', $data);
    }

    // Token Creation
    public function token($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result),0,$length);
    }

    // Register Validation and Completion Method
    public function regcomplete()
    {
        helper(['form']);
        $rules = [
            'name'              => 'required|min_length[5]|max_length[50]',
            'email'             => 'required|min_length[12]|max_length[100]|valid_email|is_unique[users.email]',
            'password'          => 'required|min_length[8]|max_length[50]',
            'confirmpassword'   => 'matches[password]'
        ];

        $errormsg = [
            'email' => [
                'is_unique' => 'Email is already in use. You\'ll need to use a different email to register.'
            ],
            'confirmpassword' => [
                'matches'   =>'The confirm password field does not match the password field.'
            ]

        ];

        if($this->validate($rules, $errormsg))
        {
            $model = model(UserModel::class);
            $data = [
                'name'      => $this->request->getVar('name'),
                'email'     => $this->request->getVar('email'),
                'password'  => password_hash($this->request->getVar('password'),PASSWORD_DEFAULT),
                'token'     => $this->token(100)
            ];
            $model->insertUser($data);
            $data['title']= 'Registration Complete';
            $data['main_content'] = 'regcompleteView';
            
            echo view ('innerpages/template', $data);

        }else{
            $data['validation']= $this->validator;
            $data['title']= 'Register';
            $data['main_content'] = 'registerView';
            echo view ('innerpages/template', $data);
        }
        
    }

    // Registration Verification Method
    public function register_verify($token=null)
    {
        $model = model(UserModel::class);
        $data = [
            'token' => $this->token(100),
            'status'=> 1
        ];
        
        $model->updateUser($data,$token);
        return redirect('signin');
    }

    // Sign In Page
    public function signin()
    {
        helper(['form']);
        $data = [];
        $data['title']= 'Sign In';
        $data['main_content'] = 'signinView';
        echo view ('innerpages/template', $data);
    }

    
    //Sign In Verification method
    public function signin_verify()
    {
        $data = [];
        helper(['form']);
        $rules = [
            'email'             => 'required|min_length[12]|max_length[100]|valid_email',
            'password'          => 'required|min_length[8]|max_length[50]|validate_user[email,password]|validate_user_status[email]'
            
        ];

        $errormsg = [
            'password' => [
                'validate_user'           => 'Email or Password don\'t match.',
                'validate_user_status'    => 'Your account status is not active yet, 
                                    Please request an activation link from your administrator.'
            ]
        ];

        if($this->validate($rules, $errormsg))
        {
            $model = model(UserModel::class);
            $email = $this->request->getVar('email');
            $user = $model->getUser($email);
            $this->set_session($user);

            return redirect('contacts');

        }else{
            $data['validation']= $this->validator;
            $data['title']= 'Sign In';
            $data['main_content'] = 'signinView';
            echo view ('innerpages/template', $data);
        }
    }

    //Set Session Method
    private function set_session($user)
    {
        $data = [
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'isLoggedIn' => true

        ];
        session();
        session()->set($data);
        return true;
    }

    //Sign Out Method
    public function signout()
    {
        session();
        session()->destroy();
        return redirect('signin');
    }

}