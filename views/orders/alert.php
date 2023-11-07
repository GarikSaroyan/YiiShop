<?php
use yii\helpers\Html;

?>
<table class="table table-fixed">
    <thead>
    <tr>
        <th class="form-control-dark">Name
            <input id='searchName' placeholder="Search" class='form-control' name="count[]"/>
        </th>
    </tr>
    </thead>


    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Select</th>
        <th scope="col">Name</th>
        <th scope="col">Count</th>
    </tr>
    </thead>


    <tbody id="alertBody" class="table table-scroll table-striped">

    </tbody>
</table>

<div class="form-group">
    <Button id="btn-success" class='btn btn-success'>Save</Button>
</div>


