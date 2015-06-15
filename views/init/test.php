<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function rec_disp($acc) {
   
    echo '<ul>';
    foreach($acc as $a){
        echo '<li>'.$a->name.'</li>';
        
        // Recursive
        if (empty($a->children))
            rec_disp($a->children);

    }
    echo '</ul>';
}
?>
<h1>Chart of accounts <small><?= $chart ?></small></h1>

<ul>
<?php 
//rec_disp($accounts);
var_dump($accounts);
?>
</ul>