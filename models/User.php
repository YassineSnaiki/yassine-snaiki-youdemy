<?php

namespace app\models;

use app\core\Application;

class User {
    private  $id = null;
    private  $username;
    private  $email;
    private  $password = '';
    private $role = 'student';
    private $isactive = true;
    

    public function __construct($email,$password,$username,$id=null,$role='student',$isactive=true) {
        $this->setId($id);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRole($role);
        $this->setIsactive($isactive);
    }
    public function getId(){
        return $this->id;
    }
    public function getusername(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getRole(){
        return $this->role;
    }
    public function getIsactive(){
        return $this->isactive;
    }
    public function setId($id){
         $this->id = $id;
    }
    public function setusername($username){
         $this->username = $username;
    }
    public function setEmail($email){
         $this->email = $email;
    }
    public function setPassword($password){
         $this->password = $password;
    }
    public function setRole($role){
         $this->role = $role;
    }
    public function setIsactive($isactive){
        $this->isactive = $isactive;
    }
    public static function getAll(){
        $allUsers = Application::$app->db->query("select * from users")->getAll();
        $users=[];
        foreach($allUsers as $user){
            $users[] = new self($user['email'],$user['password'],$user['username'],$user['id'],$user['role'],$user['isactive']);
        }
        return $users;
    }
    public static function validateLogin($email,$password) {
        $errors = [];
        if (empty($email)) {
            $errors['email_error'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password_error'] = "Password is required.";
        } 
        elseif (strlen($password) < 4) {
            $errors['password_error'] = "Password must be at least 4 characters long.";
        }
        if (!empty($errors)) {
            return $errors;
        } else {
            return true;
        }
    }
    public static function validateRegister($email,$password,$confirm_password,$username) {
        $errors = [];
        $emailTaken = Application::$app->db->query("select * from users where email = ?",[$email])->getOne();
        $usernameTaken = Application::$app->db->query("select * from users where username = ?",[$username])->getOne();
        if($emailTaken){
            $errors['email_error'] = "Email is already taken.";
            $_SESSION['error'] = "Email is already taken.";
        }elseif($usernameTaken){   
            $errors['username_error'] = "Username is already taken.";
            $_SESSION['error'] = "Email is already taken.";
        }
        if (empty($email)) {
            $errors['email_error'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password_error'] = "Password is required.";
        }
        elseif (strlen($password) < 4) {
            $errors['password_error'] = "Password must be at least 4 characters long.";
        }if ($password !== $confirm_password) {
            $errors['confirm_error'] = "Passwords do not match.";
        } 
        if(empty($username)) {
            $errors['username_error'] = "Username is required.";
        } elseif(strlen($username) < 4){
            $errors['username_error'] = "Username must be at least 4 characters long.";
        }
        if (!empty($errors)) {
            return $errors;
        } else {
            return true;
        }
    }

    public static function suspendedCount() {
        $count = Application::$app->db->query("select count(*) from users where isactive = false")->getOne()['count'];
        return $count;
    }
    public static function getSuspendedPaginated($limit,$offset){ 
        $usersAssoc = Application::$app->db->query("select * from users where isactive = false limit ? offset ?",[$limit,$offset])->getAll();
        $users=[];
        foreach($usersAssoc as $user){
            $users[] = new self($user['email'],$user['password'],$user['username'],$user['id'],$user['role'],$user['isactive']);
        }
        return $users;
    }
    
    public static function findByEmail($email) {
        $user = Application::$app->db->query("SELECT id,email,password,username,role,isactive FROM users WHERE email = ?",[$email])->getOne();
        if (empty($user)) {
            return false;
        }else {
            return new self($user["email"], $user["password"], $user["username"],$user['id'], $user["role"], $user["isactive"]);
        }
    }
    public static function findById($id) {

        $user = Application::$app->db->query("SELECT id,email,password,username,role,isactive FROM users WHERE id = ?",[$id])->getOne();

        if (empty($user)) {
            return false;
        }else {
            return new self($user["email"], $user["password"], $user["username"],$user['id'], $user["role"], $user["isactive"]);
        }
    }
    public function checkPassword($password) {
        return password_verify($password,$this->password);
    }
    public function save() {
        $id = Application::$app->db->query("INSERT INTO users (username , email, password, role, isactive) 
             VALUES (?,?,?,?,?) RETURNING id",[$this->username,$this->email,$this->password,$this->role,$this->isactive])->getOne()['id'];
        $this->id = $id;
        return true;
    }
    public function update() {
        Application::$app->db->query("UPDATE users SET username = ? , email = ?, password = ?, role = ?, isactive = ? WHERE id = ?",[$this->username,$this->email,$this->password,$this->role,$this->isactive ? 1 : 0,$this->id]);
        return true;
    }
    public function delete(){
        Application::$app->db->query("DELETE FROM users where id = ?",[ $this->id ]);
        return true;
    }
}
