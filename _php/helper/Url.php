<?php

/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 24/10/2016
 * Time: 20:14
 */
namespace helper;

class Url
{
    private $url;

    public function __construct(){
        $this->url = substr($_SERVER['REQUEST_URI'],stripos($_SERVER['PHP_SELF'],basename($_SERVER['SCRIPT_FILENAME'])));;
    }

    private function convertedUrl(){
        $data   = array('%20');
        $replace= array(" ");
        $theUrl = str_replace($data,$replace, $this->url);
        return $theUrl;
    }

    public function isLocal(){
        if(preg_match('/\d+\.\d+\.\d+\.\d+/',$_SERVER["SERVER_NAME"]) || $_SERVER["SERVER_NAME"] == 'localhost'){
            return true;
        }
        return false;
    }

    public function getByIndex($index){
        $r  = explode("/", $this->url);
        if(array_key_exists($index, $r)){
            $result = $r[$index];
            $final  = explode('?', $result);

            return $final[0];
        }
        else{
            return false;
        }
    }

    private function generateVariable(){
        $req_url    =  $this->convertedUrl();
        $r          = explode('/',$req_url);
        $data       = array();

        if(count($r)%2==0){
            for($i=0;$i<count($r);$i++){
                $data[$r[$i++]]=$r[$i];
            }
        }
        else{
            for($i=0;$i<count($r)-1;$i++){
                $data[$r[$i++]]=$r[$i];
            }
        }

        return $data;
    }
}