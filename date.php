<?php 
    class Date{

        var $name_days = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
        var $name_months = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre','Janvier','Février');


        public function getAllDate($predate)
        {
            $r = array();
            $date = strtotime($predate.'-01');            
            while(strtotime(date('Y-m',$date)) <= strtotime($predate.'+2 MONTH')){
                $y = date('Y',$date);
                $m = date('n',$date);
                $d = date('j',$date);
                $w = str_replace('0','7',date('w',$date));
                $r[$y][$m][$d] = $w;
                $date = strtotime(date('Y-m-d',$date).'+1 DAY');
            }
            return $r;
        }

    }
?>