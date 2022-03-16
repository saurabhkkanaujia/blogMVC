<?php

namespace App\Controllers;

use App\Libraries\Controller;

class Pages extends Controller
{
    public function signup()
    {
        $this->view('signup');
    }
    public function signin()
    {
        $this->view('signin');
    }
    public function users()
    {
        if (!isset($_SESSION['userData'])) {
            $this->signin();
        } else {
            $data = $this->fetchUsers();
            $this->view('panel/users', $data);
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['userData'])) {
            $this->signin();
        } else{
            $data['users'] = $this->fetchUsers();
            $data['posts'] = $this->fetchPosts();
            $this->view('panel/dashboard', $data);
        }
        
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
            $data = $this->model('User')::find(array(
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ));

            if (!isset($data->email)) {
                $data = [
                    'msg'=>'Please signup first!!'
                ];
                $this->view('signin', $data);
            } elseif ($data->status != 'Approved') {
                $data = ['msg'=>"You aren't approved yet!!"];
                $this->view('signin', $data);
            } else {
                $_SESSION['userData']['id'] = $data->id;
                $_SESSION['userData']['name'] = $data->name;
                $_SESSION['userData']['email'] = $data->email;
                $_SESSION['userData']['status'] =$data->status;
                $_SESSION['userData']['role'] = $data->role;

                $this->dashboard();
                
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
        $list = $this->model('User')::all();
        return $list;
    }

    public function fetchPosts() {
        $list = $this->model('Blog')::all();
        return $list;
    }

    public function userAction() {
        if (!isset($_POST['deleteUser'])) {
            $id = isset($_POST['approve'])?$_POST['approve']:$_POST['restrict'];
            $user = $this->model('User')::find_by_id($id);
            if ($user->status == 'Not Approved') {
                $user->status = 'Approved';
            } else {
                $user->status = 'Not Approved';
            }
            $user->save();
        } elseif (isset($_POST['deleteUser'])) {
            $user = $this->model('User')::find_by_id($_POST['deleteUser']);
            $user->delete();
        }
        
        $this->users();
        // $this->view('panel/users', $data);
    }

    public function posts() {
        if (!isset($_SESSION['userData'])) {
            $this->signin();
        } elseif ($_SESSION['userData']['role'] == 'admin') {
            $data = $this->fetchPosts();
            $this->view('panel/posts', $data);

        } elseif ($_SESSION['userData']['role'] == 'user') {
            $data = $this->model('Blog')::all(array('conditions' => array('user_email = ?', $_SESSION['userData']['email'])));
            $this->view('panel/posts', $data);

        }
        
    }

    public function addPost() {
        if (!isset($_SESSION['userData'])) {
            $this->signin();
        } else {
            $this->view('panel/add_post');
        }
    }

    public function publishPost()
    {
        if (isset($_POST['publish'])) {
            if ($this->checkData($_POST['title'], $_POST['category'], $_POST['description'], 'random')) {
                $posts = $this->model('Blog') ;
                $posts->user_email = $_SESSION['userData']['email'] ;
                $posts->title = $_POST['title'] ;
                $posts->category = $_POST['category'] ;
                $posts->description = $_POST['description'] ;
                $posts->content = $_POST['content'] ;
                $posts->save();
                $this->posts();
            } else {
                $data=[
                    'msg'=>'Invalid Input!!'
                ];
                $this->view('panel/add_post', $data);
            }
        }
        
    }

    public function alterPost() {
        if (isset($_POST['deletePost'])) {
            $id = $_POST['deletePost'];
            $post = $this->model('Blog')::find_by_post_id($id);
            $post->delete();
        } elseif (isset($_POST['updatePost'])) {
            $id = $_POST['updatePost'];
            $post = $this->model('Blog')::find_by_post_id($id);
            $post->title = $_POST['title'];
            $post->category = $_POST['category'];
            $post->description = $_POST['description'];
            $post->content = $_POST['content'];
            $post->save();
        } elseif (isset($_POST['approve']) || isset($_POST['restrict'])) {
            $id = isset($_POST['approve'])?$_POST['approve']:$_POST['restrict'];
            $blog = $this->model('Blog')::find_by_post_id($id);
            if ($blog->status == 'Not Approved') {
                $blog->status = 'Approved';
            } else {
                $blog->status = 'Not Approved';
            }
            $blog->save();
        }
        $this->posts();
    }

    public function editPost() {
        $id = $_GET['id'];
        $data = $this->model('Blog')::find_by_post_id($id);
        $this->view('panel/edit_post', $data);
    }

    public function searchPost() {
        if (isset($_POST['searchPost'])) {
            $toSearch = $_POST['searchField'];
            $data = $this->model('Blog')::all(array('conditions' => array('post_id = ? OR title LIKE "%'.$toSearch.'%" OR category LIKE "%'.$toSearch.'%"', $toSearch )));
            $this->view('panel/posts', $data);
        }
    }

    public function searchUser() {
        if (isset($_POST['searchUser'])) {
            $toSearch = $_POST['searchField'];
            $data = $this->model('User')::all(array('conditions' => array('id = ? OR name LIKE "%'.$toSearch.'%" OR email LIKE "%'.$toSearch.'%"', $toSearch )));
            $this->view('panel/users', $data);
        }
    }
    public function signOut() {
        session_destroy();
        $this->signin();
    }

    public function home() {
        $data = $this->model('Blog')::all(array('conditions' => array('status = "Approved"')));
        $this->view('home', $data);
    }
    public function blog() {
        if(isset($_POST['singleBlog'])) {
            $id = $_POST['singleBlog'];
            $data = $this->model('Blog')::find_by_post_id($id);
            $this->view('single_blog', $data);
        } else {
            $this->home();
        }
    }

    public function changeBlogStatus() {
        $id = isset($_POST['approve'])?$_POST['approve']:$_POST['restrict'];
        $blog = $this->model('Blog')::find_by_id($id);
        if ($blog->status == 'Not Approved') {
            $blog->status = 'Approved';
        } else {
            $blog->status = 'Not Approved';
        }
        $blog->save();
        $this->posts();
    }
}
