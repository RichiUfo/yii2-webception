<?php var_dump($histo); ?>

<table class="table table-striped">
<tbody>
<?php foreach($histo as $date => $val) : ?>
<tr>
    <td><?= $date ?></td>
    <td><?= $val ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>