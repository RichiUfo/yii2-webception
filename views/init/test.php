<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function rec_disp($acc) {
    // Display <ul><li>
    echo '<ul>';
    foreach($acc->account as $a){
        echo '<li>'.$a->name.'</li>';
        
        // Recursive
        if (isset($a->account)) {
            if (is_array($a->account)) rec_disp($a->account);
            else echo '<ul><li>'.$a->name.'</li></ul>';
        }
    }
    echo '</ul>';
}
?>


<h1>Chart of accounts <small><?= $chart ?></small></h1>

<ul>
<?php 
rec_disp($accounts); 

var_dump($accounts);
?>
</ul>