<?php var_dump($histo); ?>

<table class="table table-striped">
<tbody>
<?php foreach($histo as $h) : ?>
<tr>
    <td><?= $h->date ?></td>
    <td><?= $h->value ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>