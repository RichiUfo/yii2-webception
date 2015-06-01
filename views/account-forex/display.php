<?php

use yii\helpers\Url;

use frontend\modules\accounting\assets\BaseAsset;
BaseAsset::register($this);

?>

<!-- LEFT PANEL -->
<!--?php $this->render('@app/views/partials/left_panel', [
    'back_button' => $back_button,
    'left_menus' => $left_menus
]); ?-->

<!-- MAIN CONTENT -->
<h2 class="text-center">Forex Accounts</h2>

<div id="forex-accounts" class="row">
    <div class="col-lg-12">
        
        <table class="table table-striped">
			<thead>
				<tr>
					<th>Account</th>
					<th></th>
					<th></th>
					<th></th>
					<th>Value</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($forex as $account) : ?>
				<tr>
					<td><?= $account->account->alias ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?= $account->account->display_value ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			
		</table>
        
    </div>
</div>