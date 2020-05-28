<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
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
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Demo Shop2 admin',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $navMenus = [
	    ['label' => 'Role', 'url' => ['/rbac/role']],
        ['label' => 'Route', 'url' => ['/rbac/route']],
		['label' => 'Permission', 'url' => ['/rbac/permission']],
		['label' => 'Assignment', 'url' => ['/rbac/assignment']],
    ];
    $menuItems = [
	    ['label' => 'Website', 'url' => '/frontend/web'],
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems = [
            ['label' => 'Website', 'url' => '/frontend/web'],
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Role', "items" => $navMenus],
            ['label' => 'Log', 'url' => ['/actionlog/log/index']],
            ['label' => 'Accounts', 'url' => ['/user/index']],
            ['label' => 'Brands', 'url' => ['/brand/index']],
            ['label' => 'Categories', 'url' => ['/category/index']],
            ['label' => 'Products', 'url' => ['/product/index']],
            ['label' => 'Reports', 'url' => ['/order/report']],
            ['label' => 'Orders', 'url' => ['/order/index']],
            ['label' => 'Menu', 'url' => ['/menu/index']],
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
