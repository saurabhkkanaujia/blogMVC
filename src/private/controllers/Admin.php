<?php

namespace App\Controllers;

use App\Libraries\Controller;

class Admin extends Controller
{
    public function signup()
    {
        $this->view('signup');
    }
    public function signin()
    {
        $this->view('signin');
    }
    public function dashboard()
    {
        $data['allUsers'] = $this->fetchUsers();
        $this->view('panel/dashboard', $data);
    }
    
    public function userSignup()
    {
        if (isset($_POST['register'])) {
            if ($this->checkData($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password2'])) {
                if ($_POST['password']!=$_POST['password2']) {
                    $data = [
                        'msg'=> 'Password and Confirm Password do not match!!'
                    ];
                    $this->view('signup', $data);
                } else {
                    $users = $this->model('User') ;
                    $users->name = $_POST['name'] ;
                    $users->email = $_POST['email'] ;
                    $users->password = $_POST['password'] ;
                    $users->save();
                    $data = [
                        'msg'=> 'Account Created Successfully'
                    ];
                    $this->view('signin', $data);
                }
            } else {
                $data = [
                    'msg'=> 'Invalid Input!!'
                ];
                $this->view('signup', $data);
            }
        }
    }
    public function userLogin() {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $data['users'] = $this->model('User')::find(array(
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ));
            if (!isset($data['users']->email)) {
                $data = [
                    'msg'=>'Please signup first!!'
                ];
                $this->view('signin', $data);
            } elseif($data['users']->status != 'Approved') {
                $data['msg'] = "You aren't approved yet!!";
                $this->view('signin', $data);
            } else {
                $_SESSION['user'] = $data['users'];
                $data['allUsers'] = $this->fetchUsers();
                $this->view('panel/dashboard', $data);

            }
        }
    }

    public function checkData($name, $email, $password, $password2)
    {
        if (strlen($name)==0 || strlen($email)==0 || strlen($password)==0 || strlen($password2)==0) {
            return false;
        }
        return true;
    }

    public function fetchUsers() {
        $list = $this->model('User')::all() ;
        return $list;
    }
}
