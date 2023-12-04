<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use practically\chartjs\Chart;
use yii\jui\DatePicker;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;


try {
    $this->registerCssFile('@web/css/dashboard/bootstrap-datepicker.min.css');
    $this->registerCssFile('@web/css/dashboard/_cards.scss');
    $this->registerCssFile('@web/css/dashboard/flag-icon.min.css');
    $this->registerCssFile('@web/css/dashboard/font-awesome.min.css');
    $this->registerCssFile('@web/css/dashboard/materialdesignicons.min.css');
    $this->registerCssFile('@web/css/dashboard/style.css');
    $this->registerCssFile('@web/css/dashboard/vendor.bundle.base.css');
} catch (\yii\base\InvalidConfigException $e) {
}
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;


$d = strtotime("0 week -1 day");
$start_week = strtotime("last Monday  midnight", $d);
$end_week = strtotime("next Sunday ", $d);
$start = date("Y-m-d", $start_week);
$end = date("Y-m-d", $end_week);

$fromDate = $start;
$toDate = $end;


$dWeek = strtotime("0 week -1 day");
$start_week = strtotime("last Monday  midnight", $dWeek);
$between = strtotime("last Thursday  midnight", $dWeek);
$end_week = strtotime("next Sunday ", $dWeek);

$startWeek = date("Y-m-d", $start_week);
$between = date("Y-m-d", $between);
$endWeek = date("Y-m-d", $end_week);

if (isset($_GET['from'])) {

    $from = explode('-', $_GET['from']);
    $from[1] = $from[1] - 1;
    $between = $from;
    $between[2] = abs(round(((31-$between[2]) -$between[2] )/ 2));

    $to = $_GET['from'];

    $startWeek = implode('-',$from);
    $between = implode('-',$between);
    $endWeek = $_GET['from'];
}


$targetDate = \app\models\Target::find()->asArray()->all();
$orders = \app\models\Orders::find()->asArray()->all();
$orderItems = \app\models\OrderItems::find()->asArray()->all();
$store = \app\models\Store::find()->asArray()->all();
$product = \app\models\Product::find()->asArray()->all();

$targetDateWeek = \app\models\Target::find()->where(['between', 'date', $startWeek, $endWeek])->asArray()->all();
$ordersWeek = \app\models\Orders::find()->where(['between', 'date', $startWeek, $endWeek])->asArray()->all();

if (isset($_GET['from']) && $_GET['from']) {
    $fromDate = $_GET['from'];
    $toDate = $_GET['to'];
    $true = \app\models\Target::find()->where(['between', 'date', $fromDate, $toDate])->asArray()->all();
    if (!empty($true)) {
        \app\models\Target::find()->where(['between', 'date', $fromDate, $toDate])->asArray()->all() &&
        $targetDate = \app\models\Target::find()->where(['between', 'date', $fromDate, $toDate])->asArray()->all();
        \app\models\Orders::find()->where(['between', 'date', $fromDate, $toDate])->asArray()->all()
        &&  $orders = \app\models\Orders::find()->where(['between', 'date', $fromDate, $toDate])->asArray()->all();

    }

}

//var_dump(Yii::$app->user->isGuest);
?>
    <div class="site-about" xmlns="http://www.w3.org/1999/html">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="main-panel">
            <div class="content-wrapper pb-0">
                <div class="page-header flex-wrap">

                </div>
                <div class="row">
                    <?php

                    $productId = \app\models\OrderItems::find()->select(['productId'])->asArray()->all();
                    $productIdNew = [];
                    foreach ($productId as $value) {
                        array_push($productIdNew, $value['productId']);
                    }
                    $productId = array_unique($productIdNew);
                    $orderItemsProductId = array_column($orderItems, 'productId');

                    array_multisort($orderItemsProductId, SORT_ASC, $orderItems);

                    $arrProduct = [];

                    foreach ($productId as $id) {
                        $arrProduct[$id] = 0;
                        foreach ($orderItems as $item) {
                            if ($id === $item['productId']) {
                                $arrProduct[$id] += $item['addCount'];
                            }
                        }
                    }

                    $max = 0;
                    $maxId = 0;
                    foreach ($arrProduct as $key => $item) {
                        if ($max < $item) {
                            $max = $item;
                            $maxId = $key;
                        }
                    }

                    $found_key = array_search($maxId, array_column($orderItems, 'productId'));
                    $maxOrderItem = $orderItems[$found_key];
                    $foundProduct = array_search($maxId, array_column($product, 'id'));

                    $maxPrice = \app\models\OrderItems::find()->max('price');
                    $maxPriceName = array_search($maxPrice, array_column($orderItems, 'price'));
                    $maxProductName = array_search($orderItems[$maxPriceName]['productId'], array_column($product, 'id'));


                    ?>
                    <div class="col-xl-3 col-lg-12 stretch-card grid-margin">
                        <div class="row">
                            <div class="col-xl-12 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                                <div class="card bg-warning">
                                    <div class="card-body px-3 py-4">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="color-card">
                                                <p class="mb-0 color-card-head">Amena tank</p>
                                                <h2 class="text-white"> <?= $maxPrice ?> dram</h2>
                                            </div>
                                        </div>
                                        <h6 class="text-white"><?= $product[$maxProductName]['name'] ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                                <div class="card bg-danger">
                                    <div class="card-body px-3 py-4">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="color-card">
                                                <p class="mb-0 color-card-head">Amenashat Vacharvac</p>
                                                <h2 class="text-white"><?= $max ?> hat <br>
                                                    <?= $maxOrderItem['price'] * $max ?> dram</h2>
                                            </div>
                                        </div>
                                        <h6 class="text-white"> <?= $product[$foundProduct]['name'] ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3 pb-lg-0 pb-xl-3">
                                <div class="card bg-primary">
                                    <div class="card-body px-3 py-4">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="color-card">
                                                <p class="mb-0 color-card-head">Orders</p>
                                                <h2 class="text-white"> $1,753.<span class="h5">00</span>
                                                </h2>
                                            </div>
                                        </div>
                                        <h6 class="text-white">67.98% Since last month</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-9 stretch-card grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <h5>Business Survey</h5>
                                        <p class="text-muted"> Show overview<a
                                                    class="text-muted font-weight-medium pl-2" href="#"></a></p>
                                    </div>

                                </div>
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="card mb-3 mb-sm-0">
                                                <div class="card-body py-3 px-2">
                                                    From

                                                    <?php

                                                    echo DatePicker::widget([
                                                        'name' => 'from',
                                                        'value' => $fromDate,
                                                        'options' => ['class' => 'datePicker'],
                                                        //'language' => 'ru',
                                                        'dateFormat' => 'yyyy-MM-dd',
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card mb-3 mb-sm-0">
                                                <div class="card-body py-3 px-3">
                                                    To
                                                    <?php echo DatePicker::widget([
                                                        'name' => 'to',
                                                        'value' => $toDate,
                                                        'options' => ['class' => 'datePicker'],
                                                        //'language' => 'ru',
                                                        'dateFormat' => 'yyyy-MM-dd',
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card mb-3 mb-sm-0">
                                                <button type="submit" class="btn btn-success">ok</button>

                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="row my-3">
                                    <div class="col-sm-12">
                                        <div class="flot-chart-wrapper">
                                            <div id="flotChart" class="flot-chart px-2">

                                                <?php

                                                function createSeries($targetDate)
                                                {
                                                    $targetDateNames = \app\models\Target::find()->select(['storeName'])->asArray()->all();
                                                    $name = [];
                                                    foreach ($targetDateNames as $key => $item) {
                                                        array_push($name, $item["storeName"]);
                                                    }
                                                    $name = array_unique($name);

                                                    $seriesTargetDate = [];
                                                    foreach ($name as $item) {
                                                        $dateName = [];
                                                        $dateName['name'] = $item;
                                                        $data = [];
                                                        foreach ($targetDate as $kay => $value) {
                                                            if ($item === $value['storeName']) {
                                                                array_push($data, [$value['date'], $value['price']]);
                                                            }
                                                        }

                                                        $dateName['data'] = $data;
                                                        array_push($seriesTargetDate, $dateName);
                                                    }
                                                    return $seriesTargetDate;
                                                }

                                                $seriesTargetDate = createSeries($targetDate);
                                                ?>
                                                <h5 class="flotChartH5">Target</h5>
                                                <?php
                                                echo \onmotion\apexcharts\ApexchartsWidget::widget([
                                                    'type' => 'bar', // default area
                                                    'height' => '270', // default 350
                                                    'width' => '100%', // default 100%
                                                    'chartOptions' => [
                                                        'chart' => [
                                                            'toolbar' => [
                                                                'show' => true,
                                                                'autoSelected' => 'zoom'
                                                            ],
                                                        ],
                                                        'xaxis' => [
                                                            'type' => 'datetime',
                                                            // 'categories' => $categories,
                                                        ],
                                                        'plotOptions' => [
                                                            'bar' => [
                                                                'horizontal' => false,
                                                                'endingShape' => 'rounded'
                                                            ],
                                                        ],

                                                        'stroke' => [
                                                            'show' => true,
                                                            'colors' => ['transparent']
                                                        ],
                                                        'legend' => [
                                                            'verticalAlign' => 'bottom',
                                                            'horizontalAlign' => 'left',
                                                        ],
                                                    ],
                                                    'series' => $seriesTargetDate
                                                ]);
                                                ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 stretch-card grid-margin ml-auto">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="flotChartH5">Orders</h5>
                            <?php

                            $storeData = [];
                            foreach ($store as $key => $item) {
                                $storeData[$item['id']] = $item['name'];
                            }

                            $ordersData = [];

                            foreach ($orders as $item) {

                                $arr = [];
                                $arr['id'] = $item['id'];
                                $arr['date'] = $item['date'];
                                $arr['storeName'] = $storeData[$item['storeId']];
                                $arr['price'] = $item['totalPrice'];
                                $arr['addCount'] = $item['addCount'];
                                array_push($ordersData, $arr);
                            }

                            $dateSort = array_column($ordersData, 'date');
                            $storeNameSort = array_column($ordersData, 'storeName');

                            array_multisort($dateSort, SORT_ASC, $storeNameSort, SORT_DESC, $ordersData);//

                            $sortData = [];
                            $time = $ordersData[0]['date'];
                            $name = $ordersData[0]['storeName'];
                            $reduce = 0;

                            for ($i = 0; $i < count($ordersData); $i++) {
                                if ($i + 1 === count($ordersData)) {
                                    $arr = [];
                                    $arr['storeName'] = $name;
                                    $arr['date'] = $time;
                                    $arr['price'] = $reduce + $ordersData[$i]['price'];;
                                    array_push($sortData, $arr);
                                    break;
                                }
                                if ($ordersData[$i]['date'] === $time) {
                                    if ($ordersData[$i]['storeName'] === $name) {
                                        $reduce += $ordersData[$i]['price'];
                                    } else {
                                        $arr = [];
                                        $arr['storeName'] = $name;
                                        $arr['date'] = $time;
                                        $arr['price'] = $reduce;
                                        array_push($sortData, $arr);

                                        $name = $ordersData[$i]['storeName'];
                                        $reduce = $ordersData[$i]['price'];

                                    }
                                } else {
                                    $arr = [];
                                    $arr['storeName'] = $name;
                                    $arr['date'] = $time;
                                    $arr['price'] = $reduce;
                                    array_push($sortData, $arr);

                                    if ($ordersData[$i]['storeName'] != $name) {
                                        $name = $ordersData[$i]['storeName'];
                                    }
                                    $time = $ordersData[$i]['date'];
                                    $reduce = $ordersData[$i]['price'];
                                }
                            }
                            $ordersDataSort = createSeries($sortData);


                            echo \onmotion\apexcharts\ApexchartsWidget::widget([
                                'type' => 'bar', // default area
                                'height' => '300', // default 350
                                'width' => '100%', // default 100%
                                'chartOptions' => [
                                    'chart' => [
                                        'toolbar' => [
                                            'show' => true,
                                            'autoSelected' => 'zoom'
                                        ],
                                    ],
                                    'xaxis' => [
                                        'type' => 'datetime',
                                        // 'categories' => $categories,
                                    ],
                                    'plotOptions' => [
                                        'bar' => [
                                            'horizontal' => false,
                                            'endingShape' => 'rounded'
                                        ],
                                    ],

                                    'stroke' => [
                                        'show' => true,
                                        'colors' => ['transparent']
                                    ],
                                    'legend' => [
                                        'verticalAlign' => 'bottom',
                                        'horizontalAlign' => 'left',
                                    ],
                                ],
                                'series' => $ordersDataSort
                            ]);
                            ?>

                        </div>
                    </div>
                </div>


                <div class="col-xl-9 stretch-card grid-margin ml-auto">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="flotChartH5">Naxord <?php
                                if (isset($_GET['from'])) {
                                    echo 'amsva';}
                                else {
                                    echo 'shabatva';
                                }
                                ?> ekamut</h5>
                            <?php
                            $orderItems = \app\models\OrderItems::find()
                                ->joinWith('orders')
                                ->where(['between', 'date', $startWeek, $endWeek])
                                ->asArray()
                                ->all();

                            $storeId = \app\models\OrderItems::find()
                                ->select(['storeId'])
                                ->asArray()
                                ->all();

                            $storeIdNew = [];
                            foreach ($storeId as $value) {
                                array_push($storeIdNew, $value['storeId']);
                            }
                            $storeId = array_unique($storeIdNew);

                            function revenue($arr, $productId, $storeId, $between, $store)
                            {

                                $arrRevenue = [];
                                foreach ($storeId as $value) {
                                    $arrRevenueNumber = [];

                                    foreach ($productId as $id) {

                                        $arrRevenueNumber['price'] = 0;
                                        foreach ($arr as $item) {
                                            if ($value === $item['storeId']) {
                                                $arrRevenueNumber['price'] += $item['addCount'] * $item['revenue'];
                                            }
                                        }
                                    }
                                    $arrRevenueNumber['date'] = $between;

                                    foreach ($store as $storeName) {
                                        if ($storeName['id'] === $value) {
                                            $arrRevenueNumber['storeName'] = $storeName['name'];
                                            break;
                                        }
                                    }
                                    array_push($arrRevenue, $arrRevenueNumber);

                                }


                                return $arrRevenue;
                            }


                            $revenueDataSort = createSeries(revenue($orderItems, $productId, $storeId, $between, $store));

                            echo \onmotion\apexcharts\ApexchartsWidget::widget([
                                'type' => 'bar', // default area
                                'height' => '300', // default 350
                                'width' => '100%', // default 100%
                                'chartOptions' => [
                                    'chart' => [
                                        'toolbar' => [
                                            'show' => true,
                                            'autoSelected' => 'zoom'
                                        ],
                                    ],
                                    'xaxis' => [
                                        'type' => 'datetime',
//                                         'categories' => $categories,
                                    ],
                                    'plotOptions' => [
                                        'bar' => [
                                            'horizontal' => false,
                                            'endingShape' => 'rounded'
                                        ],
                                    ],

                                    'stroke' => [
                                        'show' => true,
                                        'colors' => ['transparent']
                                    ],
                                    'legend' => [
                                        'verticalAlign' => 'bottom',
                                        'horizontalAlign' => 'left',
                                    ],
                                ],
                                'series' => $revenueDataSort
                            ]);
                            ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

<?php
//$series = [
//                                                [
//                                                    'name' => 'Entity 1',
//                                                    'data' => [
//                                                        ['2018-10-02', 7],
//                                                        ['2018-10-04', 9.66],
//                                                        ['2018-10-05', 4.0],
//                                                    ],
//                                                ],
//                                                [
//                                                    'name' => 'Entity 2',
//                                                    'data' => [
//                                                        ['2018-10-02', 7],
//                                                        ['2018-10-04', 10.88],
//                                                        ['2018-10-05', 7.77],
//                                                    ],
//                                                ],
//                                                [
//                                                    'name' => 'Entity 3',
//                                                    'data' => [
//                                                        ['2018-10-02', 7],
//                                                        ['2018-10-04', 8.40],
//                                                        ['2018-10-05', 4.0],
//                                                    ],
//                                                ],
//                                                [
//                                                    'name' => 'Entity 4',
//                                                    'data' => [
//                                                        ['2018-10-02', 7],
//                                                        ['2018-10-04', 4.5],
//                                                        ['2018-10-05', 10.18],
//                                                    ],
//                                                ],
//                                                [
//                                                    'name' => 'Entity 5',
//                                                    'data' => [
//                                                        ['2018-10-02', 8],
//                                                        ['2018-10-04', 4.5],
//                                                        ['2018-10-05', 10.18],
//                                                    ],
//                                                ],
//
//                                            ];
?>