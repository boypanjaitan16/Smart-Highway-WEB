<?php

/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 14/^02$/2017
 * Time: 11:39
 */
namespace helper;

class Timing
{
    public function dinamicTime($time)
    {
        $out    = null;
        $range  = time()-$time;

        if ($range <= (259200*2)){ //3 days
            if ($range <= 86400){ //1 days
                if ($range <= 3600){ //1 hour
                    if($range <= 120){// 2 minutes
                        $out    = '<span title="'.date("d M Y, H:i", $time).'">baru saja</span>';
                    }
                    else{
                        $out    = '<span title="'.date("d M Y, H:i", $time).'">'.floor($range/60).' minutes ago</span>';
                    }
                }
                else{
                    $out    = '<span title="'.date("d M Y, H:i", $time).'">'.floor($range/3600).' hours ago</span>';
                }
            }
            else{
                $out    = '<span title="'.date("d M Y, H:i", $time).'">'.floor($range/86400).' days ago</span>';
            }
        }
        else{
            $out    = date("d", $time)." ".$this->getStrMonth($time)." ".date("Y, H:i", $time)." WIB";
        }

        return $out;
    }

    public function getDetailTime($time){
        $out    = null;
        $range  = time()-$time;

        if ($range <= (259200*2)){ //3 days
            if ($range <= 86400){ //1 days
                if ($range <= 3600){ //1 hour
                    if($range <= 120){// 2 minutes
                        $out    = '<span title="'.date("d M Y, H:i", $time).'">just now</span>';
                    }
                    else{
                        $out    = '<span title="'.date("d M Y, H:i", $time).'">'.floor($range/60).' minutes ago</span>';
                    }
                }
                else{
                    $out    = '<span title="'.date("d M Y, H:i", $time).'">'.floor($range/3600).' hours ago</span>';
                }
            }
            else{
                $out    = '<span title="'.date("d M Y, H:i", $time).'">'.floor($range/86400).' days ago</span>';
            }
        }
        else{
            $out    = $this->getStrDay($time).", ".date("d", $time)." ".$this->getStrMonth($time).date(" Y, H:i ", $time)." WIB";
        }

        return $out;
    }

    public function getStrDay($tmp){
        $a  = array(0,1,2,3,4,5,6);
        $b  = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');

        return str_replace($a, $b, date("w", $tmp));
    }

    public function getStrMonth($tmp){
        $a  = array('/^1$/','/^2$/','/^3$/','/^4$/','/^5$/','/^6$/','/^7$/','/^8$/','/^9$/','/^10$/','/^11$/','/^12$/');
        $b  = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

        return preg_replace($a, $b, date("n", $tmp));
    }

    public function greeting(){
        $hours  = date("H");
        if ($hours >= 1 && $hours <=11){
            return 'Pagi';
        }
        elseif ($hours >= 12 && $hours <= 14){
            return 'Siang';
        }
        elseif ($hours >= 15 && $hours <= 17){
            return 'Sore';
        }
        else{
            return 'Malam';
        }
    }
}