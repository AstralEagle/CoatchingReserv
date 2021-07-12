<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Calendrier</title>
        <link rel="stylesheet" type="text/css" href="style_calendrier.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="script.js"></script>
</head>
<body>
    <?php  
        require('date.php');
        require('config.php');
        $date = new Date();
        $reserv = new Config();
        $now = date('Y-m');
        $today = date('Y-m-d');
        $dates = $date->getAllDate($now);
        $reservs = $reserv->getAllReserv($today);
    ?>
    <section id='calendar'>
        <div class="monthsList">
            <ul id="listMonth">
                <?php 
                foreach($dates as $y=>$selected){
                    foreach($selected as $m=>$lastSelec){
                        ?>
                        <li><a href="#" id="linkMonth<?php echo $m?>">
                            <p class="monthInfoY"><?php echo $y;?></p>
                            <p class="monthInfoM">
                            <?php echo substr($date->name_months[$m-1],0,3);?>
                            </p>
                        </a></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div>
        <?php
            foreach($dates as $y=>$selectMonth){
                foreach($selectMonth as $m=>$selectDay){
                    ?>
                    <div class="month" id="month<?php echo $m;?>">
                        <table>
                            <thead>
                                <tr class="thead">
                                    <?php 
                                    foreach($date->name_days as $d){
                                        ?>
                                        <th><?php echo substr($d,0,3); ?></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $end = end($selectDay);
                                    foreach($selectDay as $d=>$w){
                                        $daySelect = strtotime("$y-$m-$d");
                                        if($d == 1){
                                            if($w !=1){
                                                ?>
                                                <td colspan="<?php echo $w-1; ?>" class="colspan"></td>
                                                <?php
                                        }}?>
                                        <td <?php 
                                            if($daySelect == strtotime(date('Y-m-d'))){
                                            ?>class="today"<?php
                                            }?>>
                                            <div class="relative">
                                                <div class="days" >
                                                    <?php if(isset($reservs[$daySelect])){ ?>
                                                <a class="clickCase" href="reservation.php?id=<?php echo $daySelect;?>">
                                                <?php }?>
                                                    <?php echo $d; ?>
                                                    <?php if(isset($reservs[$daySelect])){ ?>
                                                        </a>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <ul class="events">
                                                <?php
                                                if(isset($reservs[$daySelect])){
                                                    ?>
                                                    <li><ul><?php
                                                    foreach($reservs[$daySelect] as $time=>$e){
                                                        ?>
                                                        <li class="lol"><?php echo $time;?></li>
                                                        <?php
                                                    }?></ul></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </td> 
                                        <?php
                                        if($w == 7){
                                            ?>
                                            </tr>
                                            <tr>
                                            <?php
                                        }
                                    }
                                    if($end != 7){
                                        ?>
                                        <td colspan="<?php echo 7-$end; ?>" class="colspan"></td>
                                        <?php
                                    }

                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
            }
        ?>
        </div>
    </section>
</body>
</html>