<?php

class Secpass {

    public $db_path = "../../database.db";
    public $db_connection;

    
    public function __construct() {
        $this->db_connection = new SQLite3($this->db_path);
    }

    function is_firtTime(){
        if(!file_exists("src/hello")){
            fopen("src/hello", "w");
            return TRUE; //if is first time
        }else{
            return FALSE;
        }
    }

    function is_fileAlone($scriptname){
        if (basename($_SERVER['SCRIPT_FILENAME']) == $scriptname){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function firstTimeConfig() {
            if ($this->db_connection) {
                $result = $this->db_connection->exec("create table codeLog (code varchar(255), namee varchar(50), checksumm varchar(50));");
                if (!$result) {
                    die("Error creating table: " . $this->db_connection->lastErrorMsg());
                }

                $result = $this->db_connection->exec("create table passwords (id INTEGER PRIMARY KEY AUTOINCREMENT, user varchar(1000),passwordd varchar(1000),descriptionn varchar(1000));");
                if ($result) {
                    return true;
                } else {
                    echo "Error creating table: " . $this->db_connection->lastErrorMsg();
                    return false;
                }
 
 
            } else {
                echo "Error opening/creating database.";
            }
        
        
    }

    function makeItFirtsTime(){
        unlink("src/hello");
        unlink("../../database.db");
    }

    function encrypt($plaintext, $password) {
        $method = "AES-256-CBC";
        $key = hash('sha256', $password, true);
        $iv = openssl_random_pseudo_bytes(16);
    
        $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
        $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);
    
        return $iv . $hash . $ciphertext;
    }
    
    function decrypt($ivHashCiphertext, $password) {
        $method = "AES-256-CBC";
        $iv = substr($ivHashCiphertext, 0, 16);
        $hash = substr($ivHashCiphertext, 16, 32);
        $ciphertext = substr($ivHashCiphertext, 48);
        $key = hash('sha256', $password, true);
    
        if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) return null;
    
        return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
    }   

    function getName(){
        $result = $this->db_connection->query("select namee from codeLog;");
        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $name = $row['namee'];
            return $name;
        }else{
            die("Error: database name invalid");
        }
    }

    function isPasswordCorrect($code, $password){
        if($this->decrypt($code, $password) == "batata"){
            return true;
        }else{
            return false;
        }
    }

}