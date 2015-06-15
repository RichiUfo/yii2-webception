<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function rec_disp($acc) {
    
    // Display <li>
    echo '<li>'.$acc->name.'</li>';
    
    // Recursive
    if ($acc->account) {
        echo '<ul>';
        foreach($acc->account as $a)
            rec_disp($a);
        echo '</ul>';
    }
    
}
?>


<h1>Chart of accounts <small><?= $chart ?></small></h1>

<ul>
<?php 
rec_disp($accounts->accounts); 
?>
</ul>