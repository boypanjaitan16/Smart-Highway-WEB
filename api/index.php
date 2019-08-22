<?php
/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 04/03/2018
 * Time: 11:59
 */

session_start();
date_default_timezone_set('Asia/Jakarta');

require_once ("../_php/autoloader.php");
require_once ("../_php/dbconnector.php");

$config     = new helper\Configuration();
$url        = new helper\Url();
$assets     = new helper\Assets("../".$config->getAssetsDir());
$session    = $config->getSessionAdmin();
$output     = array('status'=>'failed','message'=>'Action unknown');
$categori   = $url->getByIndex(0);

switch ($url->getByIndex(0)){
    case "road":
        switch ($url->getByIndex(1)){
            case "get-all":
                $query = $cnc->query(null, "SELECT * FROM highway_road ORDER BY id DESC");

                $data = array();
                while ($dbquery = $query->fetch(PDO::FETCH_OBJ)) {
                    $outGate        = $cnc->query(array(':id'=>$dbquery->id), "SELECT * FROM highway_outgate WHERE road=:id");
                    $dbquery->out   = $outGate->fetchAll(PDO::FETCH_OBJ);

                    array_push($data, $dbquery);
                }
                //$output['status']   = 'success';

                $output = array('status' => 'success', 'data' => $data);
                break;
            case "place-order":
                if(isset($_POST['memberId'], $_POST['roadId'], $_POST["gateId"])) {
                    if (!empty($_POST['memberId'] && $_POST['roadId'] && $_POST["gateId"])) {

                        try{
                            //$type		= preg_replace('/\W+/','',strtolower($_POST['roadType']));
                            $getPrice	= $cnc->query(array(':id'=>$_POST['gateId']), "SELECT price FROM highway_outgate WHERE id=:id");
                            $getBalance	= $cnc->query(array(':id'=>$_POST['memberId']), "SELECT balance FROM highway_balance WHERE id=:id");

                            if($getPrice->rowCount() > 0 && $getBalance->rowCount() > 0){
                                $thePrice		= $getPrice->fetch(PDO::FETCH_OBJ);
                                $theBalance		= $getBalance->fetch(PDO::FETCH_OBJ);
                                $resultBalance	= $theBalance->balance - $thePrice->price;

                                if($resultBalance >= 0){
                                    $cnc->query(array(':id'=>$_POST['memberId'], ':bl'=>$resultBalance), "UPDATE highway_balance SET balance=:bl WHERE id=:id");
                                    $query = $cnc->query(array(':rid' => $_POST['roadId'], ':mid'=>$_POST['memberId']),
                                        "INSERT INTO highway_activity (memberId,roadId,`time`) VALUES (:mid,:rid,UNIX_TIMESTAMP())");
                                    //$output['status']   = 'success';

                                    $balance    = array('balance'=>$resultBalance);
                                    $output     = array('status'=>'success', 'data'=>$balance);
                                }
                                else{
                                    $output["price"]    = $thePrice->price;
                                    $output["balance"]  = $theBalance->balance;
                                    $output['message']	= 'Saldo anda tidak mencukupi untuk melakukan tindakan ini';
                                }

                            }
                            else{

                                $output['message']	= 'beberapa data tidak ditemukan, proses tidak dapat dilanjutkan';
                            }

                        }
                        catch(PDOException $e){
                            $output['message']	= $e->getMessage();
                        }
                    }
                }
                break;
        }
        break;
    case "member":
        switch($url->getByIndex(1)){
            case 'update-fbm-token':
                if(isset($_POST['id'], $_POST['token'])){
                    if(!empty($_POST['token'])){
                        $cnc->query(array(':id'=>$_POST['id'], ':tkn'=>$_POST['token']), "UPDATE highway_member SET token=:tkn WHERE id=:id");
                        $output['status']   = 'success';
                    }
                }
                break;
            case "get-activities":
                if(isset($_POST['id'])){
                    $data 	= array();
                    $setActivities	= $cnc->query(array(':id'=>$_POST['id']), "SELECT * FROM highway_activity WHERE memberId=:id ORDER BY id DESC");
                    while($getActivities = $setActivities->fetch(PDO::FETCH_OBJ)){
                        $setRoad	= $cnc->query(array(':id'=>$getActivities->roadId), "SELECT * FROM highway_road WHERE id=:id");
                        while($getRoad = $setRoad->fetch(PDO::FETCH_OBJ)){
                            $child          = array();
                            $child['id']    = $getRoad->id;
                            $child['name']  = $getRoad->name;
                            $child['distance']  = $getRoad->distance;
                            $child['price']    = $getRoad->price;
                        }
                        array_push($data, array('date'=>date("d M Y, H:i",$getActivities->time), 'type'=>$getActivities->roadType, 'road'=>$child));
                    }
                    $output['status']	= 'success';
                    $output['data']		= $data;
                }
                break;
            case "check-balance":
                if(isset($_POST['memberId'], $_POST['roadId'], $_POST["gateId"])) {
                    if (!empty($_POST['memberId'] && $_POST['roadId'] && $_POST["gateId"])) {

                        try{
                            //$type		= preg_replace('/\W+/','',strtolower($_POST['roadType']));
                            $getPrice	= $cnc->query(array(':id'=>$_POST['gateId']), "SELECT price FROM highway_outgate WHERE id=:id");
                            $getBalance	= $cnc->query(array(':id'=>$_POST['memberId']), "SELECT balance FROM highway_balance WHERE id=:id");

                            if($getPrice->rowCount() > 0 && $getBalance->rowCount() > 0){
                                $thePrice		= $getPrice->fetch(PDO::FETCH_OBJ);
                                $theBalance		= $getBalance->fetch(PDO::FETCH_OBJ);
                                $resultBalance	= $theBalance->balance - $thePrice->price;

                                if($resultBalance >= 0){
                                    $output['status']   = 'success';
                                    $output["sisa"]     = $resultBalance;
                                }
                                else{
                                    $output['message']	= 'Saldo anda tidak mencukupi untuk melakukan tindakan ini';
                                }

                            }
                            else{
                                $output['message']	= 'beberapa data tidak ditemukan, proses tidak dapat dilanjutkan';
                            }

                        }
                        catch(PDOException $e){
                            $output['message']	= $e->getMessage();
                        }
                    }
                }
                break;
            case 'top-up':
                if(isset($_POST['id'], $_POST['nominal'])){
                    if(!empty($_POST['id'] && $_POST['nominal'])){
                        $cnc->query(array(':mid'=>$_POST['id'], ':nmnl'=>$_POST['nominal']), "INSERT INTO highway_topup (memberId,nominal,`time`,status) VALUES (:mid,:nmnl,UNIX_TIMESTAMP(),'0')");
                        $output['status']	= 'success';
                    }
                    else{
                        $output['message']	= 'anda harus mengisikan jumlah nominal';
                    }
                }
                break;
            case 'register' :
                if (isset($_POST['username'], $_POST['password'], $_POST['name'], $_POST['email'], $_POST['phone'])){
                    if (!empty($_POST['username']&& $_POST['password']&& $_POST['name']&& $_POST['email'] && $_POST['phone'])){
                        try{
                            if (!preg_match('/\W+/', $_POST['username'])){
                                $cek    = $cnc->query(array(':id'=>$_POST['username']), "SELECT id FROM highway_member WHERE id=:id");
                                if ($cek->rowCount() == 0) {
                                    $cnc->query(array(':id' => $_POST['username'], ':pass' => $_POST['password'], ':nm' => $_POST['name'], ':em' => $_POST['email'], ':ph'=>$_POST['phone']), "INSERT INTO highway_member (id,password,`name`,email,phone) VALUES (:id,:pass,:nm,:em,:ph)");
                                    $cnc->query(array(':id'=>$_POST['username']), "INSERT INTO highway_balance (id) VALUES (:id)");
                                    $output['status'] = 'success';
                                }
                                else{
                                    $output['message']  = 'Username tersebut sudah digunakan oleh akun lain';
                                }
                            }
                            else{
                                $output['message']  = 'Username hanya bisa berupa huruf dan angka';
                            }
                        }
                        catch (PDOException $e){
                            $output['message']  = $e->getMessage();
                        }
                    }
                    else{
                        $output['message']  = 'Semua field harus di isi';
                    }
                }
                break;
            case 'login'    :
                if (isset($_POST['id'], $_POST['password'], $_POST['token'])){
                    if (!empty($_POST['id'] && $_POST['password'] && $_POST['token'])){
                        $cek    = $cnc->query(array(':id'=>$_POST['id']), "SELECT id AS username,name,email,phone,password FROM highway_member WHERE id=:id");
                        if ($cek->rowCount() > 0){
                            $data   = $cek->fetch(PDO::FETCH_OBJ);
                            if ($data->password == $_POST['password']){
                                $cnc->query(array(':id'=>$_POST['id'], ':tkn'=>$_POST['token']), "UPDATE highway_member SET token=:tkn WHERE id=:id");
                                $output['status']   = 'success';
                                $output['data']     = array(
                                                        'name'=>$data->name,
                                                        'username'=>$data->username,
                                                        'email'=>$data->email,
                                                        'phone'=>$data->phone,
                                                        'password'=>$data->password,
                                                        'token'=>$_POST['token']);
                            }
                            else{
                                $output['message']  = 'Password anda tidak sesuai';
                            }
                        }
                        else{
                            $output['message']   = 'Username anda tidak terdaftar';
                        }
                    }
                    else{
                        $output['message']  = 'Data request login tidak lengkap';
                    }
                }
                break;
            case "get-profile":
                if (isset($_POST['id'])){
                    $cek    = $cnc->query(array(':id'=>$_POST['id']), "SELECT * FROM highway_member WHERE id=:id");
                    if ($cek->rowCount() > 0){
                        $values     = $cek->fetch(PDO::FETCH_OBJ);
                        $data       = array('name'=>$values->name,'username'=>$values->id, 'email'=>$values->email, 'phone'=>$values->phone, 'password'=>$values->password);
                        $output     = array('status'=>'success', 'data'=>$data);
                    }
                    else{
                        $output['message']  = 'Profile anda tidak ditemukan';
                    }
                }
                break;
            case 'set-profile':
                if (isset($_POST['id'], $_POST['password'], $_POST['name'], $_POST['email'], $_POST['phone'])){
                    if (!empty($_POST['id']&& $_POST['password']&& $_POST['name']&& $_POST['email'] && $_POST['phone'])){
                        try{
                            $cnc->query(array(':id' => $_POST['id'],':ph'=>$_POST['phone'], ':pass' => $_POST['password'], ':nm' => $_POST['name'], ':em' => $_POST['email']),
                                "UPDATE highway_member SET password=:pass,name=:nm,email=:em,phone=:ph WHERE id=:id");
                            $output['status'] = 'success';

                        }
                        catch (PDOException $e){
                            $output['message']  = $e->getMessage();
                        }
                    }
                    else{
                        $output['message']  = 'Semua field harus di isi';
                    }
                }
                else{
                    $output["message"]	= "set-profile exception";
                }
                break;
            case "get-balance":
                if(isset($_POST['id'])){
                    $setBalance = $cnc->query(array(':id'=>$_POST['id']), "SELECT balance FROM highway_balance WHERE id=:id");
                    if ($setBalance->rowCount() > 0){
                        $getBalance = $setBalance->fetch(PDO::FETCH_OBJ);
                        $data       = array('username'=>$_POST['id'], 'balance'=>$getBalance->balance);
                        $output     = array('status'=>'success', 'data'=>$data);
                    }
                    else{
                        $output['message']  = 'username akun ini tidak terdaftar';
                    }
                }
                break;
        }
        break;
    default:
        break;
}
echo json_encode($output);
?>