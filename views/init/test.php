<?php 

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

$rec_disp = function ($acc) {
    
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


<h1>Chart of accounts</h1>

<ul>
<?php 
//rec_disp($account); 
?>
</ul>