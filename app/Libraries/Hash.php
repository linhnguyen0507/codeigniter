<?php 
namespace App\Libraries;
class Hash{
    public static function encrypt($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
    public static function checkPassword($passwordInput, $password){
        if (password_verify($passwordInput, $password) ) {
            return true;
        }
        return false;
    }
}
