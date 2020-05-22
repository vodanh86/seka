<?php 
use common\models\Product;
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use frontend\assets\AppAsset;

$this->title = 'Shop';

AppAsset::register($this);
$back_img = null;
?>
	
	<section id="slider"><!--slider-->
		<div >
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-12 no-padding">
									<img width="100%" src="<?php echo Yii::getAlias('@web')?>/images/home/girl2.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-12 no-padding">
									<img  width="100%"  src="<?php echo Yii::getAlias('@web')?>/images/home/girl1.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-12 no-padding">
									<img  width="100%"  src="<?php echo Yii::getAlias('@web')?>/images/home/girl3.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				
				<div class="col-sm-12 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản phẩm mới</h2>
						<?php 
						$products = Product::find()
						->where(['new' => 1])
						->all();
						?>
						<?php foreach($products as $product): ?>
							<div class="col-md-4 ">
								<div class="">
									<div class=" hs-wrapper2">
									<a href="catalog/view?id=<?= $product['id']?>">
									<?php $primage = \common\models\Product::getProductImagesById($product['id']);
										if (count($primage) > 0) {
									?>
									<?=Html::img(\common\models\ProductImage::getProductImgUrl($primage[0]['id'], $primage[0]['product_id'])) ?>
									<? } ?>
									
								</div>
								<h5><?=$product['title'] ?></h5> </a>
								<div class="simpleCart_shelfItem">
									<p><?php if(\Yii::$app->user->isGuest): ?><i class="item_price">$<?=$product['price'] ?></i><?php else: ?><span>$<?=$product['price'] ?></span> <i class="item_price">$<?=$product['price']*0.8 ?></i><?php endif;?></p>
								</div> 
								
							</div>
						</div>
						<?php endforeach; ?>
						
					</div><!--features_items-->
					<?php
						$categories = Category::find()
						->where(['<>','id', 1])
						->all();
					?>
					<div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<?php 
								for($i=0; $i < count($categories); $i ++) {
									$category = $categories[$i];?>
								<li <?php if ($i == 0) echo " class='active' " ?>><a href="#<?='cat'.$category->id?>" data-toggle="tab"><?=$category->title?></a></li>
								<? } ?>
							</ul>
						</div>
						<div class="tab-content">
							<?php 
							for($i=0; $i < count($categories); $i ++) {
								$category = $categories[$i];?>
							
							<div class="tab-pane fade <?php if ($i == 0) echo " active in " ?>" id="<?='cat'.$category->id?>" >
							<?php 
							$products = Product::find()
							->where(['category_id' => $category->id])
							->all();
							?>
							<?php foreach($products as $product): ?>
								<div class="col-md-4 ">
									<div class="">
										<div class=" hs-wrapper2">
										<a href="catalog/view?id=<?= $product['id']?>">
										<?php $primage = \common\models\Product::getProductImagesById($product['id']);
											if (count($primage) > 0) {
										?>
										<?=Html::img(\common\models\ProductImage::getProductImgUrl($primage[0]['id'], $primage[0]['product_id'])) ?>
										<? } ?>
										
									</div>
									<h5><?=$product['title'] ?></h5> </a>
									<div class="simpleCart_shelfItem">
										<p><?php if(\Yii::$app->user->isGuest): ?><i class="item_price">$<?=$product['price'] ?></i><?php else: ?><span>$<?=$product['price'] ?></span> <i class="item_price">$<?=$product['price']*0.8 ?></i><?php endif;?></p>
									</div> 
									
								</div>
							</div>
						<?php endforeach; ?>
							</div>

							<?php } ?>
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Sản phẩm bán chạy</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php 
									$products = Product::find()
									->where(['recommend' => 1])
									->all();
									$allProducts = Array();
									for ($i=0; $i < 6; $i ++){
										$allProducts = array_merge($allProducts, $products);
									}
								?>
								<div class="item active">	
									<?php for ($i=0; $i < 3; $i ++){ 
										$product = $allProducts[$i] ?>
											<div class="col-md-4 ">
												<div class="">
													<div class=" hs-wrapper2">
													<a href="catalog/view?id=<?= $product['id']?>">
													<?php $primage = \common\models\Product::getProductImagesById($product['id']);
														if (count($primage) > 0) {
													?>
													<?=Html::img(\common\models\ProductImage::getProductImgUrl($primage[0]['id'], $primage[0]['product_id'])) ?>
													<? } ?>
													
												</div>
												<h5><?=$product['title'] ?></h5> </a>
												<div class="simpleCart_shelfItem">
													<p><?php if(\Yii::$app->user->isGuest): ?><i class="item_price">$<?=$product['price'] ?></i><?php else: ?><span>$<?=$product['price'] ?></span> <i class="item_price">$<?=$product['price']*0.8 ?></i><?php endif;?></p>
												</div> 
												
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="item">	
								<?php for ($i=3; $i < 6; $i ++){ 
										$product = $allProducts[$i] ?>
										<div class="col-md-4 ">
											<div class="">
												<a data-toggle="modal" href="#rec<?=$i?>">
													<div class=" hs-wrapper2">
														<?php $primage = \common\models\Product::getProductImagesById($product['id']);
															if (count($primage) > 0) {
														?>
														<?=Html::img(\common\models\ProductImage::getProductImgUrl($primage[0]['id'], $primage[0]['product_id'])) ?>
														<? } ?>
													</div>
													<h5><?=$product['title'] ?></h5> </a>
												<div class="simpleCart_shelfItem">
													<p><?php if(\Yii::$app->user->isGuest): ?><i class="item_price">$<?=$product['price'] ?></i><?php else: ?><span>$<?=$product['price'] ?></span> <i class="item_price">$<?=$product['price']*0.8 ?></i><?php endif;?></p>
												</div> 
											
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
