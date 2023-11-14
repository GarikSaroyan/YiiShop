<?php

use yii\helpers\Html;

$this->registerCssFile("@web/css/dashboard.css", [], 'css-print-theme');


?>

<div class="sidebar">
    <div class="sidebarFixed">
        <h1 class="logo">SoftTech</h1>
        <?php
        if (Yii::$app->user->isGuest) {
            ?>

            <ul class="nav">
                <li><a href="/site/store">Login</a></li>
                <li><a href="/site/register">Register</a></li>
            </ul>

            <?php
        } else {
            ?>

            <ul class="nav">
                <li><a href="/site/about">Dashboard</a></li>
                <li><a href="/orders">Orders</a></li>
                <li><a href="/product">Product</a></li>
                <li><a href="/store">Store</a></li>
                <li><a href="/category">Category</a></li>
                <li><a href="/target">Target</a></li>
                <li>
                    <?php
                    echo Html::a('Logout',

                        ['/site/logout'],

                        ['class' => '', 'data-method'=>'post']);


                    ?>


<!--                    <a href="/site/logout">Loge Out</a></li>-->


            </ul>
        <?php } ?>
    </div>

</div>