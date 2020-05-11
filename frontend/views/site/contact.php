<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12 box-heading-contact">
				
				<div class="box-map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.615593436863!2d106.65415201477133!3d10.76408024232994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752eec7752c743%3A0xd832d71bd12b6a15!2zRmxlbWluZ3RvbiBUb3dlciwgMTgyIEzDqiDEkOG6oWkgSMOgbmgsIHBoxrDhu51uZyAxNSwgUXXhuq1uIDExLCBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1521530731757" width="100%" height="700" frameborder="0" style="border:0" allowfullscreen=""></iframe>
				</div>
				

			</div>
			<div class="col-md-6 col-sm-12 col-xs-12  wrapbox-content-page-contact">
				<div class="header-page-contact clearfix">
					<h1>Liên hệ</h1>
				</div>
				<div class="box-info-contact">
					<ul class="list-info">
						<li>
							<p>Địa chỉ chúng tôi</p>
							<p><strong>Tầng 4, tòa nhà Flemington, số 182, đường Lê Đại Hành, phường 15, quận 11, Tp. Hồ Chí Minh.</strong></p>
						</li>
						<li>
							<p>Email chúng tôi</p>
							<p><strong>hi@haravan.com</strong></p>
						</li>
						<li>
							<p>Điện thoại</p>
							<p><strong>1900.636.099</strong></p>
						</li>
						<li>
							<p>Thời gian làm việc</p>
							<p><strong>Thứ 2 đến Thứ 6 từ 8h đến 18h; Thứ 7 và Chủ nhật từ 8h00 đến 17h00 </strong></p>
						</li>
					</ul>
				</div>
				<div class="box-send-contact">
					<h2>Gửi thắc mắc cho chúng tôi</h2>
					<div id="col-left contactFormWrapper">
						<form accept-charset="UTF-8" action="/contact" class="contact-form" method="post">
<input name="form_type" type="hidden" value="contact">
<input name="utf8" type="hidden" value="✓">

						
						<div class="contact-form">
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="input-group">
										<input required="" type="text" name="contact[name]" class="form-control" placeholder="Tên của bạn" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="input-group">
										<input required="" type="text" name="contact[email]" class="form-control" placeholder="Email của bạn" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="input-group">
										<input pattern="[0-9]{10,12}" required="" type="text" name="contact[phone]" class="form-control" placeholder="Số điện thoại của bạn" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-sm-12 col-xs-12">
									<div class="input-group">
										<textarea name="contact[body]" placeholder="Nội dung"></textarea>
									</div>
								</div>
								<div class="col-xs-12">
									<button class="button dark">Gửi cho chúng tôi</button>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>

</div>
