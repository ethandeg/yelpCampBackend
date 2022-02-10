<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database {
    public function getUsers($limit) {
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }

    public function createUser($userInfo){
        //instead of putting in key placeholders, just put the actual keys in, then just worry about vals
        $keys = array_keys($userInfo);
        $values = array_values($userInfo);
        $valuePlaceholders = createPlaceholders($values);
        $params = createParams($userInfo);
        $keys = join(", ", $keys);
        // print_r(createParams($userInfo));
        $this->insert("INSERT INTO users ($keys) VALUES ($valuePlaceholders)", $params);
        // return $this->insert("INSERT INTO users (?) VALUES (?)", ["ss", $keys,$values]);

    }
    public function getUser($userKey, $userVal){
        if($userKey === 'user_id'){
            return $this->select("SELECT * FROM users WHERE user_id = ?", ["i", $userVal]);
        }
        else if($userKey === 'username'){
            return $this->select("SELECT * FROM users WHERE username = ?", ["s", $userVal]);
        }
        
    }

    public function authenticateUser($userData){
            $user = $this->select("SELECT * FROM users WHERE username = ?", ['s',$userData['username']]);
            if($user){
                $password = $user[0]['password'];
                if(password_verify($userData['password'], $password)){
                    return $user[0];
                } else {
                    throw new Error('Invalid Password');
                }

            } else {
                    throw new Error('Username does not exist');
            }
      
    }

}