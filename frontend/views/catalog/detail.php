<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use frontend\assets\AppAsset;

$this->title = 'Shop';

AppAsset::register($this);
$back_img = null;
?>
<section style="min-height:400px">
	<div class="modal-body">
		<div class="col-md-5 modal_body_left">

			<div class="product-slider">
			<div id="carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
				<?php foreach(\common\models\Product::getProductImagesById($model['id']) as $key => $primage) { ?>
					<div class="item <?= $key == 0 ? "active" : "" ?>"> 
					<?=Html::img(\common\models\ProductImage::getProductImgUrl($primage['id'], $primage['product_id']), ['class' => '', 'height' => 350]) ?>
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="clearfix">
				<div id="thumbcarousel" class="carousel slide" data-interval="false">
				<div class="carousel-inner">
					<?php
					$images = \common\models\Product::getProductImagesById($model['id']);
					for ($i = 0; $i < count($images)/3; $i ++) { ?>
					<div class="item <?= $i == 0 ? "active" : "" ?>">
						<?php for ($j = 0; $j < 3; $j ++) { 
							if ($i*3+$j < count($images)){
							$primage = $images[$j];?>
							<div data-target="#carousel" data-slide-to="<?=$i*3+$j?>" class="thumb"><img src="<?=\common\models\ProductImage::getProductImgUrl($primage['id'], $primage['product_id'])?>"></div>
						<?php }
						}?>
					</div>
					<?php } ?>
				</div>
				<!-- /carousel-inner --> 
				<a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev"> <i class="fa fa-angle-left" aria-hidden="true"></i> </a> <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next"><i class="fa fa-angle-right" aria-hidden="true"></i> </a> </div>
				<!-- /thumbcarousel --> 
				
			</div>
			</div>
		</div>
	  <div class="col-md-7 modal_body_right">
		    <h4><?=$model['title'] ?></h4>
			<p><?=$model['description'] ?></p>
	    
		
		<h5>Color</h5>
		<?= Html::beginForm(['cart/add', 'productId' => $model['id']], 'post') ?>
		    <div class="color-quality">
			  <ul>					       
      			<li><a href="#"><span></span></a></li>
				<li><a href="#" class="brown"><span></span></a></li>
				<li><a href="#" class="purple"><span></span></a></li>
				<li><a href="#" class="gray"><span></span></a></li>
			  </ul>
			  <ul>
			    <li><input type="radio" name="selected_color" value="red"  /></li>
				<li><input type="radio" name="selected_color" value="blue" /></li>
				<li><input type="radio" name="selected_color" value="brown" /></li>
				<li><input type="radio" name="selected_color" value="purple" /></li>
			  </ul>
		    </div>
		<div class="simpleCart_shelfItem">
			<p><?php if(\Yii::$app->user->isGuest): ?><i class="item_price">$<?=$model['price'] ?></i><?php else: ?><span>$<?=$model['price'] ?></span> <i class="item_price">$<?=$model['price']*0.8 ?></i><?php endif;?></p>
			<button type="submit" name="add_btn" class="w3ls-cart">Add To Cart</button>
		</div>
		<?= Html::endForm(); ?>
	  </div>
		<div class="clearfix"> </div>
	</div>
</section>