<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function rec_disp($acc) {
    // Display <ul><li>
    echo '<ul>';
    foreach($acc as $a){
        var_dump($a);
        /*echo '<li>'.$a['name'].'</li>';
        
        // Recursive
        if (isset($a['account'])) rec_disp($a['account']);*/

    }
    echo '</ul>';
}
?>


<h1>Chart of accounts <small><?= $chart ?></small></h1>

<ul>
<?php 

rec_disp($accounts['account']); 

var_dump($accounts['account']);
?>
</ul>