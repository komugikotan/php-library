<?php
/**
 * ENV-PHP
 * 
 * Licence: MIT Licence
 * Date: 2023-06-07
 * COPYRIGHT Komugikotan 2023
 * 
 * This is a function that allows to use environmental variables recorded in .env files in PHP.
 * .env files are located in document root. If you wish to change folder that includes .env 
 * file, change the contents of the varibale $ROOT_DIR.
 */

$ROOT_DIR = $_SERVER['DOCUMENT_ROOT'];
$_ENV = array();

if(file_exists("{$ROOT_DIR}/.env")){
    $ENV_CONTENT = file("{$ROOT_DIR}/.env",FILE_IGNORE_NEW_LINES);
}
else if(file_exists("{$ROOT_DIR}/.env.local")){
    $ENV_CONTENT = file("{$ROOT_DIR}/.env.local",FILE_IGNORE_NEW_LINES);
}

function ENV_LOAD($KEY){
    global $ENV_CONTENT;
    global $KEY;

    foreach($GLOBALS['ENV_CONTENT'] as $value){
        //If it contains the equal sign
        if(strpos($value, '=') && mb_substr_count($value, "=") == 1){
            $return_ary = explode('=', $value);
            if($return_ary[0] == $GLOBALS['KEY']){
                return $return_ary[1];
            }
        }
        //if it contains more than 1 equal sign
        else if(mb_substr_count($value, '=') > 1){
            $return_ary = explode('=', $value, 2);
            if($return_ary[0] == $GLOBALS['KEY']){
                return $return_ary[1];
            }
        }
    }

    return false;
}


foreach($ENV_CONTENT as $value){
    //If it contains the equal sign
    if(strpos($value, '=') && mb_substr_count($value, "=") == 1){
        $return_ary = explode('=', $value);
        $_ENV = array_merge($_ENV, array($return_ary[0]=>$return_ary[1]));
    }
    //if it contains more than 1 equal sign
    else if(mb_substr_count($value, '=') > 1){
        $return_ary = explode('=', $value, 2);
        $_ENV = array_merge($_ENV, array($return_ary[0]=>$return_ary[1]));
    }
}

?>