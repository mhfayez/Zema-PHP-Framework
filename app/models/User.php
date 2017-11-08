<?php
class User {

    // protected $email;
    //protected $password;
    //protected $role;
    protected $data = array();
    protected $role_id = '3';
    protected $user_id = '3';
    protected $user_name = "Guest";
    protected $user;
    protected $error;


    public function __construct()
    {
        Db::connect();

        if(!isset( $_SESSION['role_id'])) {
            $_SESSION['user_name'] = $this->user_name;
            $_SESSION['role_id'] = $this->role_id;
            $_SESSION['status'] = 'Logout';
        }
    }

    public function logout()
    {
       // session_unset();
       // session_destroy();
        unset( $_SESSION['user_name']);
        unset( $_SESSION['user_id']);
        unset( $_SESSION['role_id']);
        unset( $_SESSION['status']);
        $_SESSION['role_id'] = $this->getRoleId();
        $_SESSION['user_id'] = $this->getUserId();
        $_SESSION['status'] = 'loggedout';
    }

    public function login($params)
    {
        $user = $this->checkCredentials($params);
        if ($user) {
            session_unset();
            $this->user = $user;
            $_SESSION['user_name'] = $this->getUserName();
            $_SESSION['user_id'] = $this->getUserId();
            $_SESSION['role_id'] = $this->getRoleId();
            $_SESSION['status'] = 'loggedin';
            echo $_SESSION['role_id'];
            return $user;
        }
        return false;
    }

    protected function checkCredentials($params)
    {
        $query = 'SELECT * FROM users WHERE email=?';
        try {
            $stmt = Db::prepareAndExecute($query, [$params['email']], false);
            if ($stmt->rowCount() > 0) {
                $userObject = new self();
                $stmt->setFetchMode(PDO::FETCH_INTO, $userObject);
                $user = $stmt->fetch();
                //var_dump($user);
                if (password_verify($params['password'], $user->data['password'])) {
                    return $userObject;
                } else {
                    $this->error = ERROR['password'];
                    return false;
                }
            }else {
                $this->error = ERROR['username'];
                return false;
            }
        }catch (PDOstatementException $e){
            echo $e->getMessage();
        }
        return false;
    }

    public function register($user)
    {
        $password = $user["password"];
        $user['password'] = password_hash($password, PASSWORD_DEFAULT);
        $user['role_id'] = $this->role_id;
        try {
            $query ='INSERT INTO users (
                                  user_name, 
                                  password, 
                                  first_name, 
                                  last_name, 
                                  avatar, 
                                  email, 
                                  role_id 
                                  ) 
                                  VALUES(
                                  :user_name, 
                                  :password, 
                                  :first_name, 
                                  :last_name,
                                  :avatar,
                                  :email,
                                  :role_id
                                  ) ';
            Db::prepareAndExecute($query, $user, false);
            $this->user_id = DB::handler()->lastInsertId();
        }catch (PDOstatementException $e) {
            echo $e->getMessage();
        }
        try{
            $query = 'INSERT INTO users_roles(user_id, role_id) VALUES(:user_id, :role_id)';
            Db::prepareAndExecute($query, array($this->user_id, $this->role_id), false);
        }catch (PDOstatementException $e){
            echo $e->getMessage();
        }

    }

    protected function isOwner($resource_id)
    {
        if(isset($_SESSION['status']) and $_SESSION['status'] == 'loggedin' ) {
            $id = $_SESSION['user_id'];
            $query = "SELECT a.id, a.title FROM articles a INNER JOIN users_articles b ON a.id = b.article_id WHERE b.user_id = $id";
            if($_SESSION['user_id']){

            }
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getUserName()
    {
        return $this->user ? $this->user->data['user_name'] : $this->user_name;
    }

    public function getRoleId()
    {
        return $this->user ? $this->user->data['role_id'] : $this->role_id;
    }

    public function getUserId()
    {
        return $this->user ? $this->user->data['id'] : $this->user_id;
    }

    public function getUser()
    {
        return $this->user ? $this->user->data : $this;
    }

    public function getError()
    {
        return $this->error;
    }
}