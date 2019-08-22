<?php

/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 07/10/2016
 * Time: 18:50
 */
namespace helper;

use PDO;
use PDOException;

class Login
{
    private $timeLong   = 5*60;
    private $koneksi;
    private $tableToken;
    private $tableLog;
    private $tableUser;
    private $tableUserAccount;
    private $codeUser;
    private $codeAdmin;

    public function __construct($connection){
        $this->tableToken       	= "user_token";
        $this->tableLog         	= "user_log";
        $this->tableUser        	= "user_account";
        $this->tableUserAccount   	= "user_account";
        $this->codeUser   			= 1;
        $this->codeAdmin        	= 0;
        $this->koneksi              = $connection;
    }
	
    public function countTime($time){
        $realTime   = abs($time);
        $return     = null;
        $menit      = floor($realTime/60);
        $detik      = $realTime%60;

        if($menit > 0){
            $return = $menit." Minutes ".$detik." Seconds";
        }
        else{
            $return = $detik." Seconds";
        }

        return $return;
    }

    public function cekLogin($level, $username, $password) {
        $password   = hash("sha512",$password); ///ingat untuk mengubah sha512
        $output     = array('status'=>'failed', 'level'=>$level, 'message'=>'default login message');
        $publicIp   = @file_get_contents('https://api.ipify.org');

        try {
            $user = $this->koneksi->query(array(':xuser' => $username, ':lvl' => $level), "SELECT * FROM " . $this->tableUser . " WHERE username=:xuser AND `type`=:lvl");

            if ($user->rowCount() > 0) {
                $dbuser = $user->fetch(PDO::FETCH_OBJ);

                if ($this->canLogin($username, $level)) {
                    $cekTime        = $this->koneksi->query(array(':usr' => $username), "SELECT `date` FROM " . $this->tableLog . " WHERE username=:usr ORDER BY `date` DESC LIMIT 1");
                    $dataCekTime    = $cekTime->fetch(PDO::FETCH_OBJ);
                    $leftTime       = time() - ($dataCekTime->date + $this->timeLong);

                    $output['message']  = 'please wait for ' . $this->countTime($leftTime);
                    $output['time']     = $this->countTime($leftTime);
                }
                else {
                    if ($dbuser->password == $password) {

                        $token      = md5(time() . rand(1000000, 9999999) . $username);
                        $cekToken   = $this->koneksi->query(array(':lvl' => $level, ':usr' => $username), "SELECT token,startTime FROM " . $this->tableToken . " WHERE `type`=:lvl AND username=:usr AND status=1");

                        if ($cekToken->rowCount() > 0) {
                            $getToken = $cekToken->fetch(PDO::FETCH_OBJ);
                            if (time() - $getToken->startTime > 86400) { //greater than one day
                                $this->koneksi->query(array(':tkn' => $getToken->token), "UPDATE " . $this->tableToken . " SET status=0,finishTime=UNIX_TIMESTAMP() WHERE token=:tkn");
                                $this->koneksi->query(array(':usr' => $username, ':lvl' => $level, ':tkn' => $token, ':ip' => $publicIp), "INSERT INTO " . $this->tableToken . " (username, `type`, token, startTime, ipAddress, status) VALUES (:usr,:lvl,:tkn,unix_timestamp(),:ip, 1)");
                            }
                            else {
                                $token = $getToken->token;
                            }
                        }
                        else {
                            $this->koneksi->query(array(':usr' => $username, ':lvl' => $level, ':tkn' => $token, ':ip' => $publicIp), "INSERT INTO " . $this->tableToken . " (username, `type`, token, startTime, ipAddress, status) VALUES (:usr,:lvl,:tkn,unix_timestamp(),:ip, 1)");
                        }
                        $this->koneksi->query(array(':usr' => $username, ':ip' => $publicIp, ':tp' => $level, ':act' => 'login'), "INSERT INTO " . $this->tableLog . " (username,ip,`date`,`type`,`action`,status) VALUES (:usr,:ip,unix_timestamp(),:tp,:act,1)");

                        $output['token'] = $token;
                        $output['status'] = 'success';

                    }
                    else {
                        $this->koneksi->query(array(':usr' => $username, ':ip' => $publicIp, ':tp' => $level, ':act' => 'login'), "INSERT INTO " . $this->tableLog . " (username,ip,`date`,`type`,`action`,status) VALUES (:usr,:ip,unix_timestamp(),:tp,:act,0)");
                        $output['message'] = 'Password anda tidak valid';
                    }
                }
            }
            else {
                $output['message'] = 'Username anda tidak terdaftar pada sistem';
            }
        }
        catch (PDOException $e){
            $output['message']  = $e->getMessage();
        }

        return $output;
    }

    private function canLogin($username, $level) {
        $arraydb        = array(':usr'=>$username,':lvl'=>$level);
        $valid_attempts = time() - $this->timeLong;

        $query  = $this->koneksi->query($arraydb, "SELECT id FROM ".$this->tableLog." WHERE username=:usr AND `type`=:lvl AND `action`='login' AND `date` > '$valid_attempts' AND status=0");

        if ($query->rowCount() > 5) {
            return true;
        } else {
            // time() = UNIX_TIMESTAMP()
            return false;
        }

    }

    /**
     * @return string
     */
    public function getTableToken()
    {
        return $this->tableToken;
    }

    /**
     * @return string
     */
    public function getTableLog()
    {
        return $this->tableLog;
    }

    /**
     * @return string
     */
    public function getTableUser()
    {
        return $this->tableUser;
    }

    /**
     * @return string
     */
    public function getTableUserAccount()
    {
        return $this->tableUserAccount;
    }

    /**
     * @return int
     */
    public function getCodeUser()
    {
        return $this->codeUser;
    }

    /**
     * @return int
     */
    public function getCodeAdmin()
    {
        return $this->codeAdmin;
    }


}

?>