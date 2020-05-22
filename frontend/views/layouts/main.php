<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\Menu;

AppAsset::register($this);

$cart = \Yii::$app->session;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<link href='//fonts.googleapis.com/css?family=Glegoo:400,700' rel='stylesheet' type='text/css'>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<!-- //header -->
    <?php
    /*NavBar::begin([
        'options' => [
		    'id' => 'bs-megadropdown-tabs',
            'class' => 'nav navbar-inverse',
        ],
	]);
	$navMenus = [];
    foreach (Menu::find()->all() as $menu) {
        $navMenus[] = ['label' => $menu->title, 'url' => ['/menu/view', "id" => $menu->id]];
    } 
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
		['label' => 'Catalog', 'url' => ['/catalog/list']],
		['label' => 'Seka', "items" => $navMenus],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
	
	if (!Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Order History', 'url' => ['/order/index']];
    } 
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
	NavBar::end();*/
    ?>

    <div >
		<?= Alert::widget() ?>
        <?= $this->render('header') ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
		<?= $content ?>
		<?= $this->render('footer') ?>
    </div>
	
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
