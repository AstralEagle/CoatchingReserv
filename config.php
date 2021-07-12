<?php 
class Config{

    private function getDataBase(){
        try{
            $DB = new PDO('mysql:host=localhost;dbname=reservation;charset=utf8','root','root');
        }
        catch(Exception $e){
            die('Exception '.$e->getMessage());
        }
        return $DB;
    }
    private function getVerif($date){
        $DB = $this->getDataBase();
        $req = $DB->query("SELECT * FROM dispo_prof WHERE dispo_date = '".$date."'");
        $r = array();
        while($donne = $req->fetch()){
            $r[$donne['id_dispo']] = $donne;
        }
        return $r;
    }
//---------------------------------------------------------------------------------
    public function getReserv($day){
        $DB = $this->getDataBase();
        $verif = $this->getVerif($day);
        $req = $DB->query("SELECT id,date,debut,fin FROM `disponibilité` WHERE date = '".$day."' ORDER BY debut");
        $r = array();
        while($donne = $req->fetch()){
            if(!isset($verif[$donne['id']])){
                $r[$donne['debut']] = $donne;
            }
        }   
        return $r;     
    }
    
    public function getAllReserv($day){
        $DB = $this->getDataBase();
        $date = strtotime($day.'+2 DAY');
        $month = date('Y-m-d',$date);
        $req = $DB->query("SELECT id,date,debut,fin FROM `disponibilité` WHERE date >= '".$day."' ORDER BY debut");
        $r = array();
        while($donne = $req->fetch()){
            $r[strtotime($donne['date'])][$donne['debut']]=$donne['id'];
        }
        return $r;
    }  
    public function getSeance($id){
        $DB = $this->getDataBase();
        $req = $DB->query("SELECT id,date,debut,fin FROM `disponibilité` WHERE id = '".$id."'");
        $r = $req->fetch();
        return $r;
    }
    public function getAllSeance($begin, $end){
        $DB = $this->getDataBase();
        $verif = $this->getVerif($begin['date']);
        $req = $DB->query("SELECT id,date,debut,fin FROM `disponibilité` WHERE date = '".$begin['date']."' AND debut >= '".$begin['debut']."' AND fin <= '". $end ."' ORDER BY debut");
        $r = array();
        while($donne = $req->fetch()){
            if(!isset($verif[$donne['id']])){
                $r[$donne['id']]=$donne;
            }
            else{
                $r = array();
                break;
            }
        }
        return $r;
    }
    public function getAllTraining(){
        $DB = $this->getDataBase();
        $req = $DB->query("SELECT id,name FROM `training`");
        $r = array();
        while($donne = $req->fetch()){
            $r[$donne['id']]=$donne;
        }
        return $r;
    }
    public function getProfil($profil){
        $DB = $this->getDataBase();
        $req = $DB->query("SELECT id FROM profil WHERE name ='".$profil['name']."' AND adress = '".str_replace("'","\'",$profil['adress'])."' AND number_phone = '".$profil['phone']."' LIMIT 0,1");
        $r = $req->fetch()['id'];
        return $r;
    }
    public function getAgenda($day){
        $cours = $this->getVerif($day);
        $r = array();
        foreach($cours as $id=>$donne){
            $DB = $this->getDataBase();
            $req = $DB->query("SELECT debut,fin FROM disponibilité WHERE id = '".$id."' LIMIT 1");
            $dispo = $req->fetch();
            $r[$dispo['debut']] = $dispo['fin'];
        }
        return $r;
    }
//---------------------------------------------------------------------------------------
    public function newProfil($profil){
        $DB = $this->getDataBase();
        $verif = $this->getProfil($profil);
        if(empty($verif)){
            $req = $DB->prepare("INSERT INTO profil (name,adress,number_phone) VALUES (:name,:adress,:phone)");
            $req->execute($profil);
        }
    }
    public function newCoatching($seance,$idProfil,$idTrain){
        $DB = $this->getDataBase();
        $req = $DB->prepare("INSERT INTO dispo_prof (id_dispo,id_profil,id_train,dispo_date) VALUES(:dispo,:profil,:training,:date)");
        $donne = array(
            'dispo' => $seance['id'],
            'profil' =>$idProfil,
            'training' =>$idTrain,
            'date' => $seance['date']
        );
        print_r($donne);
        $req->execute($donne);
    }
    public function newDispo($dispo){
        $DB = $this->getDataBase();
        $req = $DB->prepare("INSERT INTO  disponibilité (date,debut,fin) VALUES (:date,:debut,:fin)");
        $req->execute($dispo);
    }
}
?>