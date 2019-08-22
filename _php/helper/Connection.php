<?php

/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 15/02/2016
 * Time: 20:29
 */
namespace helper;

use PDO;
use PDOException;

class Connection
{
    private $db;
	private $db_name        = "highway";
	private $db_username    = "root";
	private $db_password    = "B0yd@nnoah";

    public function __construct(){
		$this->setConfig($this->db_name, $this->db_username, $this->db_password);
    }
	
	private function setConfig($dbName, $dbUsername, $dbPassword){
		try{
            $this->db 		= new PDO('mysql:host=localhost;dbname='.$dbName,$dbUsername,$dbPassword);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo $e->getMessage();
			die();
        }
	}
	
    public function query($array, $sql){
        try{
			$return = $array != null ? $this->db->prepare($sql) : $this->db->query($sql);

			if($array != null){
				$return->execute($array);
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
        return $return;
    }

    public function data($array, $sql){
		try{
			$data   = $this->query($array, $sql);
			$dbdata = $data->fetch(PDO::FETCH_OBJ);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
        return $dbdata;

    }
}
