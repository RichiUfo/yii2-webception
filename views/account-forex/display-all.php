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
					<th>Account (owner_id)</th>
					<th class="text-right">Value</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($forex as $account) : ?>
				<tr>
					<td><?= $account->account->alias ?> (<?= $account->account->owner_id ?>)</td>
					<td class="text-right"><?= $account->account->display_value ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			
		</table>
        
    </div>
</div>

<?php var_dump(\Yii::$app->user->id); ?>