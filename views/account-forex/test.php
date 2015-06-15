<h1>Realized P&L</h1>
Amount of currency sold : <?= $res[3] ?> XYZ <br><br>

Realized = (Revenue from currency sales) - (Cost of currency sold)<br>
<?= $res[0]->realized ?> = <?= $res[1] ?> - <?= $res[2] ?><br><br>

Account ID : <?= $res[0]->account->id ?><br><br>

<h1>Operations</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Debit</th>
            <th>Credit</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($res[4] as $op) :?>
        <tr>
            <td><?= $op->transaction->accountDebit->id ?></td>
            <td><?= $op->transaction->accountCredit->id ?></td>
            <td></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
libxml_use_internal_errors(true);
$myXMLData =
"<?xml version='1.0' encoding='UTF-8'?> 
<document> 
<user>John Doe</wronguser> 
<email>john@example.com</wrongemail> 
</document>"; 

$xml = simplexml_load_string($myXMLData);
if ($xml === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
    var_dump($xml);
    print_r($xml);
}
?>