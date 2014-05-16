<div id="main"><!--main start-->
			<div class="content-box">
				<? if($paytype_id==1){?>
				<h1>Спасибо, ваш заказ №<?=$order_id;?> принят. <br />Мы перезвоним вам в течение 10 минут.</h1>
				<? 
				if(Yii::app()->user->getId()<1){
				?>
				<div class="description-box">Видео-рецепт вы можете найти на страницах заказаных блюд. </div>
				<?
				}
				}
				if($paytype_id==2){?>
				<h1>Вы сформировали заказ на гастрономический набор(ы) на сумму <span id="order_price"><?=$total;?></span> грн.</h1>
				<div class="description-box">
					Если желаете вино, специально подобранное под каждое блюдо, добавьте его к заказу или перейдите к оплате.
				</div>
				<form name="payment" id="inerkassa_form" action="http://www.interkassa.com/lib/payment.php" method="post" target="_top" enctype="application/x-www-form-urlencoded" accept-charset="cp1251">
					<fieldset>
						<input type="hidden" name="ik_shop_id" value="32C84C64-096B-5059-F3C1-E778889FB33E">
						<input type="hidden" name="ik_payment_amount" value="<?=$total;?>">
						<input type="hidden" name="ik_payment_id" value="<?=$order_id;?>">
						<input type="hidden" name="ik_payment_desc" value="Заказ №<?=$order_id;?>">
						<input type="hidden" name="ik_paysystem_alias" value="">
						<input type="hidden" name="ik_baggage_fields" value="tel: 0931520242">
						<div class="row">
							<div class="btn-holder right">
								<div class="red-btn">
									<span>Оплатить заказ</span>
									<input type="submit" name="process" value="Оплатить заказ">
								</div>
							</div>
						</div>
					</fieldset>
				</form>

				<?} if(count($drinks)>0){?>
						<div class="recomend-box">
							<h2>Рекомендованное вино к вашему блюду.</h2>
							<div class="recomend-columns">
								
									<? 
									$drinkHtml=array(0=>'',1=>'');
									$cnt=0;
									foreach($drinks as $drink){
									$drinkprice=explode('.',$drink['price']);
									
                                    $image=null;	
									if(isset($drink['image'])){
									    $image='<img src="'.$drink['image'].'">';
									}
									$drinkHtml[$cnt].='
									<li>
										<div class="img-holder">
											'.$image.'
										</div>
										<div class="text-box">
											<div class="title">'.$drink['title'].'</div>
											<p>'.$drink['detail_text'].'</p>
											<form action="/cart/adddrink/" method="post" class="add_drink">
											<input type="hidden" value="'.$order_id.'" name="order_id"/>
											<input type="hidden" value="'.$drink['id'].'" name="drink_id"/>
											<div class="bottom-tools">
												<div class="price">
													<div class="num">'.$drinkprice[0].'</div>
													<div class="currency">
														<span>'.$drinkprice[1].'</span>
														<i>грн</i>
													</div>
												</div>
												<div class="amount">
													<span>Кол-во</span>
													<label class="input-holder">
														<input type="text" name="quantity" value="1" />
													</label>
												</div>
											</div>
											<div class="btn-holder right">
												<div class="red-btn">
													<span>Добавить к заказу</span>
													<input onclick="_gaq.push([\'_trackEvent\',\'add\',\'wine\']);" type="submit" value="Добавить к заказу" class="button" />
												</div>
											</div>
											</form>
										</div>
									</li>';
									$cnt++;
									if($cnt==2)
									$cnt=0;
									}?>
								<ul class="recomend-list">
									<?=$drinkHtml[0];?>
								</ul>
								<ul class="recomend-list">
									<?=$drinkHtml[1];?>
								</ul>
								<!--<ul class="recomend-list">
									<li>
										<div class="img-holder">
											<a href="#"><img src="/images/img13.png" width="215" height="184" alt="image description" /></a>
										</div>
										<div class="text-box">
											<div class="title"><a href="#">Совиньон Блан, <br />красное полусухое</a></div>
											<p>Доставка осуществляется с 10 до 22 часов во все дни кроме воскресенья. Стоимость - 30 грн. Обычно если Вы разместили заказ до 15 часов - мы доставим его в тот же день. В любом случае во время заказа Вы увидите точное время доставки, или </p>
											<div class="bottom-tools">
												<div class="price">
													<div class="num">180</div>
													<div class="currency">
														<span>00</span>
														<i>грн</i>
													</div>
												</div>
												<div class="amount">
													<span>Кол-во</span>
													<label class="input-holder">
														<input type="text" value="1" />
													</label>
												</div>
											</div>
											<div class="btn-holder right">
												<div class="red-btn">
													<span>Добавить к заказу</span>
													<input type="button" value="Добавить к заказу" class="button" />
												</div>
											</div>
										</div>
									</li>
									<li>
										<div class="img-holder">
											<a href="#"><img src="/images/img13.png" width="215" height="184" alt="image description" /></a>
										</div>
										<div class="text-box">
											<div class="title"><a href="#">Совиньон Блан, <br />красное полусухое</a></div>
											<p>Доставка осуществляется с 10 до 22 часов во все дни кроме воскресенья. Стоимость - 30 грн. Обычно если Вы разместили заказ до 15 часов - мы доставим его в тот же </p>
											<div class="bottom-tools">
												<div class="price">
													<div class="num">180</div>
													<div class="currency">
														<span>00</span>
														<i>грн</i>
													</div>
												</div>
												<div class="amount">
													<span>Кол-во</span>
													<label class="input-holder">
														<input type="text" value="1" />
													</label>
												</div>
											</div>
											<div class="btn-holder right">
												<div class="red-btn">
													<span>Добавить к заказу</span>
													<input type="button" value="Добавить к заказу" class="button" />
												</div>
											</div>
										</div>
									</li>
									<li>
										<div class="img-holder">
											<a href="#"><img src="/images/img13.png" width="215" height="184" alt="image description" /></a>
										</div>
										<div class="text-box">
											<div class="title"><a href="#">Совиньон Блан, <br />красное полусухое</a></div>
											<p>Доставка осуществляется с 10 до 22 часов во все дни кроме воскресенья. Стоимость - 30 грн. Обычно если Вы разместили заказ до 15 часов - мы доставим его в тот же </p>
											<div class="bottom-tools">
												<div class="price">
													<div class="num">180</div>
													<div class="currency">
														<span>00</span>
														<i>грн</i>
													</div>
												</div>
												<div class="amount">
													<span>Кол-во</span>
													<label class="input-holder">
														<input type="text" value="1" />
													</label>
												</div>
											</div>
											<div class="btn-holder right">
												<div class="red-btn">
													<span>Добавить к заказу</span>
													<input type="button" value="Добавить к заказу" class="button" />
												</div>
											</div>
										</div>
									</li>
								</ul>-->
							</div>
							<div class="bottom-text">
								<div class="img-holder left">
									<img src="/images/img23.png" width="86" height="83" alt="image description" />
								</div>
								<div class="text">Мы заботимся об окружающей среде, поэтому упаковку, в которой вы получите заказ, мы с удовольствием заберем для переработки при вашем следующем заказе.</div>
							</div>
							<div class="call-popup" style="display:none;" rel="Вы успешно добавили напиток к заказу"></div>
						</div>
				<?}?>
			</div>
		</div><!--main end-->

<!-- Google Code for &#1047;&#1072;&#1082;&#1072;&#1079; &#1095;&#1077;&#1088;&#1077;&#1079; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091; Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 972037926;
    var google_conversion_language = "en";
    var google_conversion_format = "2";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "ovYDCJrLyQgQpr7AzwM";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/972037926/?label=ovYDCJrLyQgQpr7AzwM&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>

<!-- Google Code for &#1059;&#1089;&#1087;&#1077;&#1096;&#1085;&#1099;&#1081; &#1079;&#1072;&#1082;&#1072;&#1079; Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 974857459;
    var google_conversion_language = "en";
    var google_conversion_format = "2";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "AqrlCOW82AkQ88ns0AM";
    var google_conversion_value = 0;
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/974857459/?value=0&amp;label=AqrlCOW82AkQ88ns0AM&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>