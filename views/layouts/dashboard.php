<?php
//$this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", [], 'css-print-theme');

$this->registerCssFile("@web/css/dashboard.css", [], 'css-print-theme');


?>

<div class="sidebar">
    <h1 class="logo">SoftTech</h1>

    <ul class="nav">
        <li><a href="/orders"><i class="fa fa-windows"></i>Orders</a></li>
<!--        <li ><a href="/about"><i class="fa fa-shopping-bag"></i>Order Item</a></li>-->
        <li><a href="/product"><i class="fa fa-pie-chart"></i>Product</a></li>
        <li><a href="/store"><i class="fa fa-cube"></i>Store</a></li>
        <li ><a href="/category"><i class="fa fa-database"></i>Category</a></li>
        <li><a href="/target"><i class="fa fa-tag"></i>Target</a></li>

    </ul>


</div>