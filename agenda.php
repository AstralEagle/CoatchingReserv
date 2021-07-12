<?php
    session_start();
    if(isset($_GET['id']) && !empty($_GET['id'])){
        require('config.php');
        $date = date('Y-m-d',$_GET['id']);
        $config = new Config();
        $dispo = $config->getAgenda($date);
        $time = date("09:30:00");

        if(!empty($dispo)){
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="style_reserv.css">
                <title>Document</title>
            </head>
            <body>   
            <ul>
            <?php
            for($i = 0; $i<21;$i++){
                $time = strtotime($time." +30 MINUTE");
                $time = date('H:i:s',$time);
                if(isset($dispo[$time])){
                    echo '<li class="libre">'.substr($time,0,5).'</li>';                   
                }
                else{
                    echo '<li class="occuper">'. substr($time,0,5) .'</li>';                  
                }
            } ?>
            </ul>
            <pre><?php print_r($dispo); ?></pre>
            </body>
            </html>
            <?php
        }
    }
?>