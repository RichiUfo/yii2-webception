<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function rec_disp($acc) {
   
    echo '<ul>';
    foreach($acc as $a){
        $test = isset($a['children'])?'True':'False';
        echo '<li>'.$a['name'].'</li>'; 

        // Recursive
        if (isset($a['children']))
            rec_disp($a['children']);

    }
    echo '</ul>';
}
?>
<h1>Chart of accounts <small><?= $chart ?></small></h1>


<?php 
rec_disp($accounts);
?>
