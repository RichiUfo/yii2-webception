<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

function rec_disp($acc) {
    
    // Display <li>
    echo '<li>'.$acc->name.'</li>';
    
    // Recursive
    if ($acc->accounts) {
        echo '<ul>';
        foreach($acc->accounts as $a)
            rec_disp($a);
        echo '</ul>';
    }
    
}
?>


<h1>Chart of accounts <small><?= $chart ?></small></h1>

<ul>
<?php 
rec_disp($accounts->account); 
?>
</ul>