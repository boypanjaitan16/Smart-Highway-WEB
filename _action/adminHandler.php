<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

require_once ("../_php/autoloader.php");
require_once ("../_php/dbconnector.php");

$config     = new helper\Configuration();
$login      = new helper\Login($cnc);
$url        = new helper\Url();
$assets     = new helper\Assets("../".$config->getAssetsDir());
$session    = $config->getSessionAdmin();

$output     = array('status'=>'failed','message'=>'Action unknown');

if(isset($_SESSION[$session])){
    switch ($_POST['action']){
        case 'member-delete':
            if(isset($_POST['id'])) {
                try{
                    $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_member WHERE id=:id");
                    $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_balance WHERE id=:id");
                    $output['status']   = 'success';
                }
                catch (PDOException $e){
                    $output['message']  = $e->getMessage();
                }
            }
            break;
        case 'road-add':
            if (isset($_POST['out-name'], $_POST['out-distance'], $_POST['name'], $_POST['out-price'])){
                if (!empty($_POST['name'])){
                    $cnc->query(array(':nm'=>strtoupper($_POST['name'])), "INSERT INTO highway_road (`name`) VALUES (:nm)");
                    $roadId     = $cnc->data(null, "SELECT id FROM highway_road ORDER BY id DESC LIMIT 1");

                    foreach ($_POST["out-name"] as $i=>$item){
                        $cnc->query(array(':nm'=>strtoupper($item), ':ds'=>$_POST["out-distance"][$i], ':pr'=>$_POST["out-price"][$i], ':rd'=>$roadId->id),
                            "INSERT INTO highway_outgate (`name`,road,distance,price) VALUES (:nm,:rd,:ds,:pr)");
                    }

                    $output['status']   = 'success';
                }
                else{
                    $output['message']  = 'Nama jalan tidak boleh kosong';
                }
            }
            else{
                $output['message']  = 'Anda belum mengisi nama atau gerbang keluar';
            }
            break;
        case 'road-edit':
            if (isset($_POST["id"],$_POST['out-name'], $_POST['out-distance'], $_POST['name'], $_POST['out-price'])){
                if (!empty($_POST["id"] && $_POST['name'])){
                    $cnc->query(array(':nm'=>strtoupper($_POST['name']), ':id'=>$_POST["id"]), "UPDATE highway_road SET `name`=:nm WHERE id=:id");
                    $cnc->query(array(':id'=>$_POST["id"]), "DELETE FROM highway_outgate WHERE road=:id");

                    $roadId     = $cnc->data(array(':id'=>$_POST["id"]), "SELECT id FROM highway_road WHERE id=:id");

                    foreach ($_POST["out-name"] as $i=>$item){
                        $cnc->query(array(':nm'=>strtoupper($item), ':ds'=>$_POST["out-distance"][$i], ':pr'=>$_POST["out-price"][$i], ':rd'=>$roadId->id),
                            "INSERT INTO highway_outgate (`name`,road,distance,price) VALUES (:nm,:rd,:ds,:pr)");
                    }

                    $output['status']   = 'success';
                }
                else{
                    $output['message']  = 'Nama jalan tidak boleh kosong';
                }
            }
            else{
                $output['message']  = 'Anda belum mengisi nama atau gerbang keluar';
            }
            break;
        case 'road-delete':
            if(isset($_POST['id'])) {
                try{
                    $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_road WHERE id=:id");
                    $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_activity WHERE roadId=:id");

                    $output['status']   = 'success';
                }
                catch (PDOException $e){
                    $output['message']  = $e->getMessage();
                }
            }
            break;
        case 'topup-approve':
            if(isset($_POST['id'])){
                if(!empty($_POST['id'])) {
                    try{
                        $cek    = $cnc->query(array(':id'=>$_POST['id']), "SELECT memberId,nominal FROM highway_topup WHERE id=:id");
                        if ($cek->rowCount() > 0){
                            $dataCek    = $cek->fetch(PDO::FETCH_OBJ);
                            $nominal    = $dataCek->nominal;

                            $getToken   = $cnc->query(array(':id'=>$dataCek->memberId), "SELECT token FROM highway_member WHERE id=:id");

                            if($getToken->rowCount() > 0){

                                $dataToken  = $getToken->fetch(PDO::FETCH_OBJ);
                                $url        = 'https://fcm.googleapis.com/fcm/send';

                                $msg = array
                                (
                                    'title' 	=> 'Top-up Saldo',
                                    'body'		=> 'Selamat, saldo akun anda berhasil di top-up sebesar Rp. '.$nominal
                                );
                                $fields = array
                                (
                                    'registration_ids' 	=> [$dataToken->token], //device_token
                                    'notification'		=> $msg
                                );
                                $headers = array(
                                    'Authorization:key = AAAAPL2awdQ:APA91bGuCnECBKouaR64ETwUyGbO_pujT2XJkZIcjE4vUiIfZn0i7ozFs9S_3pZ94V8DH90XK-DPubuseBs3QbsjODENEPUig49B8LaD7xSfYqar2aLJF8slOSjLK-yEV2AlQQTP_bh0', //server_key
                                    'Content-Type: application/json'
                                );

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                                $result = curl_exec($ch);
                                if ($result === FALSE) {
                                    $output['message'] = 'Curl failed: ' . curl_error($ch);
                                    return;
                                }
                                curl_close($ch);

                                $cnc->query(array(':id'=>$_POST['id']), "UPDATE highway_topup SET status=1 WHERE id=:id");
                                $cnc->query(array(':id'=>$dataCek->memberId), "UPDATE highway_balance SET balance=balance+$nominal WHERE id=:id");
                                $output['status']   = 'success';
                            }
                            else{
                                $output['message']  = 'Token tidak ditemukan';
                            }
                        }
                        else{
                            $output['message']  = 'data tidak ditemukan';
                        }
                    }
                    catch (PDOException $e){
                        $output['message']  = $e->getMessage();
                    }
                }
                else{
                    $output['message']  = 'You have to fill all the fields !';
                }
            }
            break;
        case 'topup-denied':
            if(isset($_POST['id'])){
                if(!empty($_POST['id'])) {
                    try{
                        $cek    = $cnc->query(array(':id'=>$_POST['id']), "SELECT memberId FROM highway_topup WHERE id=:id");
                        if ($cek->rowCount() > 0){
                            $dataCek    = $cek->fetch(PDO::FETCH_OBJ);
                            $getToken   = $cnc->query(array(':id'=>$dataCek->memberId), "SELECT token FROM highway_member WHERE id=:id");

                            if($getToken->rowCount() > 0){
                                $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_topup WHERE id=:id");

                                $dataToken  = $getToken->fetch(PDO::FETCH_OBJ);
                                $url        = 'https://fcm.googleapis.com/fcm/send';

                                $msg = array
                                (
                                    'title' 	=> 'Top-up Saldo',
                                    'body'		=> 'Maaf, permintaan top-up anda tidak dapat diterima oleh admin. Silahkan lakukan permintaan top-up lagi di lain waktu.'
                                );
                                $fields = array
                                (
                                    'registration_ids' 	=> [$dataToken->token], //device_token
                                    'notification'		=> $msg
                                );
                                $headers = array(
                                    'Authorization:key = AAAAPL2awdQ:APA91bGuCnECBKouaR64ETwUyGbO_pujT2XJkZIcjE4vUiIfZn0i7ozFs9S_3pZ94V8DH90XK-DPubuseBs3QbsjODENEPUig49B8LaD7xSfYqar2aLJF8slOSjLK-yEV2AlQQTP_bh0', //server_key
                                    'Content-Type: application/json'
                                );

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                                $result = curl_exec($ch);
                                if ($result === FALSE) {
                                    $output['message'] = 'Curl failed: ' . curl_error($ch);
                                    return;
                                }
                                curl_close($ch);

                                $output['status']   = 'success';
                            }
                            else{
                                $output['message']  = 'Token tidak ditemukan';
                            }

                        }
                        else{
                            $output['message']  = 'data tidak ditemukan';
                        }
                    }
                    catch (PDOException $e){
                        $output['message']  = $e->getMessage();
                    }
                }
                else{
                    $output['message']  = 'You have to fill all the fields !';
                }
            }
            break;
        case 'send-broadcast':
            if(isset($_POST['title'], $_POST['body'], $_POST['receiver'])){
                if(!empty($_POST['title'] && $_POST['body'])){
                    $receivers  = json_decode($_POST['receiver']);
                    if (count($receivers) > 0){
                        $rcv    = str_replace(array("[","]", "'"), array("(",")", '"'), $_POST['receiver']);
                        $getToken   = $cnc->query(null, 'SELECT token FROM highway_member WHERE id IN '.$rcv);
                        $allToken   = $getToken->fetchAll(PDO::FETCH_OBJ);
                        $tokens     = array();

                        foreach ($allToken as $item){
                            array_push($tokens, $item->token);
                        }

                        $url        = 'https://fcm.googleapis.com/fcm/send';

                        $msg = array
                        (
                            'body' 	=> $_POST['body'],
                            'title'		=> $_POST['title']
                        );
                        $fields = array
                        (
                            'registration_ids' 	=> $tokens, //device_token
                            'notification'		=> $msg
                        );
                        $headers = array(
                            'Authorization:key = AAAAPL2awdQ:APA91bGuCnECBKouaR64ETwUyGbO_pujT2XJkZIcjE4vUiIfZn0i7ozFs9S_3pZ94V8DH90XK-DPubuseBs3QbsjODENEPUig49B8LaD7xSfYqar2aLJF8slOSjLK-yEV2AlQQTP_bh0', //server_key
                            'Content-Type: application/json'
                        );

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        if ($result === FALSE) {
                            $output['message'] = 'Curl failed: ' . curl_error($ch);
                            return;
                        }
                        curl_close($ch);
                        $output['tokens']   = $tokens;
                        $output['status']   = 'success';
                    }
                    else{
                        $output['message']  = 'Anda belum memilih penerima';
                    }
                }
                else{
                    $output['message']  = 'Judul dan isi pesan tidak boleh kosong';
                }
            }
            break;
        case 'topup-add':
            if (isset($_POST['id'], $_POST['value'])){
                if(!empty($_POST['id'] && $_POST['value'])){
                    $value  = $_POST['value'];
                    if (!preg_match('/\D+/', $value)){
                        $cnc->query(array(':id'=>$_POST['id']), "UPDATE highway_balance SET balance=balance+$value WHERE id=:id");
                        $output['status']   = 'success';
                    }
                    else{
                        $output['message']  = 'nilai saldo harus berupa angka';
                    }
                }
                else{
                    $output['message']  = 'data tidak lengkap';
                }
            }
            break;
        case 'topup-delete':
            if(isset($_POST['id'])) {
                try{
                    $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_topup WHERE id=:id");
                    $output['status']   = 'success';
                }
                catch (PDOException $e){
                    $output['message']  = $e->getMessage();
                }
            }
            break;
        case 'activity-delete':
            if(isset($_POST['id'])){
                $cnc->query(array(':id'=>$_POST['id']), "DELETE FROM highway_activity WHERE id=:id");
                $output['status']   = 'success';
            }
            break;
        case 'login':
            unset($_SESSION[$session]);
            $output['message']  = 'please reload your page';
            break;
        case 'logout':
            unset($_SESSION[$session]);
            $output['status']   = 'success';
            break;
        default:
            $output['message']  = 'action <b>'.$_POST['action'].'</b> not found';
            break;
    }
}
else{
    switch ($_POST['action']){
        case 'login':
            if(isset($_POST['username'], $_POST['password'])){
                if(!empty($_POST['username'] && $_POST['password'])) {
                    if ($_POST['username'] === 'boypanjaitan16' && $_POST['password'] === 'mypass') {
                        $output['status']   = 'success';
                        $_SESSION[$session] = array(
                            'token' =>md5(rand(4,9)),
                            'id' =>'boypanjaitan16',
                            'name' =>'Boy Panjaitan'
                        );
                    }
                    else{
                        $output['message']  = 'your credentials is not valid';
                    }
                }
                else{
                    $output['message']  = 'anda harus mengisi semua kolom yang disediakan';
                }
            }
            break;
    }
}

echo json_encode($output);
?>