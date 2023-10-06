<?php


$storeName = \app\models\Product::find()->asArray()->all();

use yii\helpers\Html;

?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Select</th>
        <th scope="col">Name</th>
        <th scope="col">Count</th>
    </tr>
    </thead>


    <tbody id="alertBody">

    <?php
    foreach ($storeName as $key => $item) { ?>
        <tr>
            <td scope='row'><?=$item['id']?></td>
            <td><input id="checkbox" type='checkbox' aria-label='Checkbox for following text input' ></td>
            <td><?= $item['name'] ?></td>
            <td><input type='number' id='typeNumber<?=$item['id']?>' class='form-control'  name="count[]"/></td>
        </tr>
        <?php
    }
    ?>

    </tbody>
</table>

<div class="form-group">
    <Button id="btn-success" class ='btn btn-success'>Save</Button>
</div>


