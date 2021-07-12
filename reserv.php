<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
}else{
    require('config.php');
    $date = date('Y-m-d',$_GET['id']);
    $config = new Config();
    $dispo = $config->getReserv($date);
    if(!empty($dispo)){
        $time = date("09:30:00");
        $trainings = $config->getAllTraining();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Réservation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style_reservation.css">
    <script src="script_reserv.js"></script>

</head>
<body>
    <div id="core">
    <ul id="agenda">
            <?php
            for($i = 0; $i<21;$i++){
                $time = strtotime($time." +30 MINUTE");
                $time = date('H:i:s',$time);
                if(isset($dispo[$time])){
                    echo '<li class="libre"><a href="#" id="reservID'.$dispo[$time]['id'].'">'.substr($time,0,5).'</a></li>';                   
                }
                else{
                    echo '<li class="occuper">'. substr($time,0,5) .'</li>';                  
                }
            } ?>
            </ul>
        <div>
            <?php 
            foreach($dispo as $timeID=>$donne){
                ?>
                <div class="commande" id="cour<?php echo $donne['id'];?>">
                    <p><?php echo $donne['debut']." / ".$donne['id']?></p>
                    <form action="confirmReserv.php?id=<?php echo $donne['id'];?>" method="post">
                        <div class="formuOne">
                            <p><label for="name">Prénom: </label><input type="text" name="name">
                            <label for="phone">Tel. </label><input type="tel" name="phone" class="inputPhone" maxlength="10" minlength="10"></p>
                            <p><label for="adress">Adresse: </label><input type="text" name="adress" class="inputAdress"></p>
                            <p><label for="postalCode">Code postal: </label><input type="phone" name="postalCode" class="inputCode" maxlength="5" minlength="5">
                            <label for="city">Ville: </label><input type="text" name="city" class="inputVille" placeholder="Ville"></p>
                            <input type="submit" value="Reserver" class="inputReserver" />
                        </div>
                        <div class="formuTwo">
                            <p><select name="training">
                            <?php foreach($trainings as $id=>$trainDonne){
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $trainDonne['name']; ?></option>
                                    <?php
                                    }?>
                            </select></p>
                            <p><?php echo substr($donne['debut'],0,5) ?> / <select name="ending">
                                <?php
                                $end = $donne['fin'];
                                ?>
                                    <option value="<?php echo $end; ?>"><?php echo substr($end,0,5); ?></option>
                                <?php
                                while(isset($dispo[$end])){
                                    if($end == $dispo[$end]['debut']){
                                        $end = $dispo[$end]['fin'];
                                        ?>
                                            <option value="<?php echo $end ?>"><?php echo substr($end,0,5); ?></option>
                                        <?php
                                    }
                                    else{
                                        break;
                                    }
                                }
                                ?>
                            </select></p>
                        </div>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
}
else{
    header('Location: index.php');
 
}}