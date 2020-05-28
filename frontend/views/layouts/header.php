
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
use yii\helpers\Url;
use yii\bootstrap\Modal;

AppAsset::register($this);

$cart = \Yii::$app->session;
?>
    <header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
        <?php                 

            Modal::begin([
                    'header' => "Don't Wait, Login now!",
                    'id' => 'myModal88',
                    'size' => 'modal-md',
                ]);?>
                        <div class="modal-body modal-body-sub">
                            <div class="row">
                                <div class="col-md-6 modal_body_left modal_body_left1" style="border-right: 1px dotted #C2C2C2;padding-right:3em;">
                                    <div class="sap_tabs">	
                                        <div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
                                            <ul>
                                            <?php if (Yii::$app->user->isGuest): ?>
                                                <li class="resp-tab-item" aria-controls="tab_item-0"><?=Html::a('<span>Sign in</span>', ['site/login']) ?></li>
                                            <?php else: ?>
                                                <li class="resp-tab-item" aria-controls="tab_item-1">
                                                <?= Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']). Html::endForm() ?>
                                                </li>
                                            <?php endif; ?>
                                            </ul>		                                                                   
                                        </div>	
                                    </div>
                                     <div id="OR" class="hidden-xs">OR</div>
                                </div>
                                <div class="col-md-6 modal_body_right modal_body_right1">
                                    <div class="row text-center sign-with">
                                        <div class="col-md-12">
                                            <h3 class="other-nw">
                                                Liên hệ hotline ... hoặc fb ... để được tư vấn"</h3>
                                        </div>
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>         
            <?php
                Modal::end();
            ?>
           
            <?php if (Yii::$app->user->isGuest && !isset($hide) && (Yii::$app->controller->action->id != "login" && Yii::$app->controller->action->id != "signup")) {?>
            <?php $this->registerJs("
                            $('#myModal88').modal('show');
                        "); ?>
            <?php } ?>
            <!-- //header modal -->
            
            <!-- header -->
            <div class="header" id="home1">
                <div class="container">
                    <div class="w3l_logo">
                        <h1><?=Html::a('Seka<span>Your stores. Your place.</span>', ['site/index']) ?></h1>
                    </div>
                    <div class="search">
                        <input class="search_box" type="checkbox" id="search_box">
                        <label class="icon-search" for="search_box"><span class="fa fa-search" aria-hidden="true"></span></label>
                        <div class="search_form">
                            <?= Html::beginForm(['catalog/list'], 'get') ?>
                                <input type="text" name="gsearch" placeholder="Search..."><input type="submit" name="_search_prod" value="Find">
                            <?= Html::endForm(); ?>
                        </div>
                    </div>
                    <div class="w3l_login">
                        <a href="#" data-toggle="modal" data-target="#myModal88"><span class="fa fa-user" aria-hidden="true"></span></a>
                    </div>
                    <div class="cart cart box_1"> 
                        <?=Html::a('<button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>', ['cart/list']) ?>
                    </div>  
                </div>
            </div>
	    <?php
   /*NavBar::begin([
        'options' => [
		    'id' => 'bs-megadropdown-tabs',
            'class' => 'nav navbar-inverse',
        ],
	]);*/
	$navMenus = [];
    foreach (Menu::find()->all() as $menu) {
        $navMenus[] = ['label' => $menu->title, 'url' => ['/menu/view', "id" => $menu->id]];
    } 
    $menuItems = [
        ['label' => 'Trang chủ', 'url' => ['/site/index']],
		['label' => 'Sản phẩm', 'url' => ['/catalog/list']],
		['label' => 'Seka', "items" => $navMenus],
        ['label' => 'Giới thiệu', 'url' => ['/site/about']],
        ['label' => 'Liên hệ', 'url' => ['/site/contact']],
    ];
	
	if (!Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Order History', 'url' => ['/order/index']];
    } 
   /* echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
	NavBar::end();*/
    ?>
		<div class="header-bottom"><!--header-bottom-->
			<div >
				<div class="row">
					<div class="col-sm-12">
						<div class="mainmenu align-middle">
							<ul class="nav navbar-nav collapse navbar-collapse">
                                <?php
                                foreach ($menuItems as $menu){
                                    if (array_key_exists("items", $menu)){
                                        echo '<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                        <ul role="menu" class="sub-menu">';
                                            foreach($menu["items"] as $item){

                                                echo '<li><a href="'.Url::to($item["url"]).'">'.$item["label"].'</a></li>';
                                            }

                                        echo ' </ul>
                                        </li> ';
                                    } else {
                                        echo '<li><a href="'.Url::to($menu["url"]).'">'.$menu["label"].'</a></li>';
                                    }
                                }
                                ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
        </div><!--/header-bottom-->
        
	</header><!--/header-->