<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class CampModel extends Database {
    public function getCamps($limit) {
        return $this->select("SELECT * FROM camps ORDER BY camp_id ASC LIMIT ?", ["i", $limit]);
    }

    public function createCamp($campInfo){
        //instead of putting in key placeholders, just put the actual keys in, then just worry about vals
        $keys = array_keys($campInfo);
        $values = array_values($campInfo);
        $valuePlaceholders = createPlaceholders($values);
        $params = createParams($campInfo);
        $keys = join(", ", $keys);
        // print_r(createParams($userInfo));
        $this->insert("INSERT INTO camps ($keys) VALUES ($valuePlaceholders)", $params);
        // return $this->insert("INSERT INTO users (?) VALUES (?)", ["ss", $keys,$values]);
    }

    public function getCampById($id){
        return $this->select("SELECT * FROM camps WHERE camp_id = ?", ["i", $id]);
        
    }
}