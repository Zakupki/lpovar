		<div id="main"><!--main start-->
			<div id="content">
				<? if(count($orders)>0){?>
				<div class="content-box">
					<h1>Ваш выбор</h1>
					<form action="/cart/updatesingle/" id="cart-form">
						<fieldset>
							<ul class="choice-list">

								<? foreach($orders as $order){
								$order['price']=explode('.',$order['price']);
								?>
								<li class="cart-item" rel="<?=$order->id;?>">
									<div class="img-holder">
                                        <? if($order->dishtype->dpid==18 && isset($order->image)){?>
                                            <img width="215" src="/<?=$order->image->path;?>/<?=$order->image->file;?>">
                                        <?}else{?>
										<a href="<?=$order->getUrl();?>"><?=(isset($order->dishThumbs[0]->thumb))?$order->dishThumbs[0]->thumb->asHtmlImage():'';?></a>
									    <?}?>
                                    </div>
									<div class="choice-frame">
										<div class="text-box">
											<a href="<?=$order->getUrl();?>"><?=$order->title;?></a>
											<a href="/cart/delete/<?=$order->id;?>/" rel="<?=$order->id;?>" class="delete">delete</a>
										</div>
										<div class="bottom-tools">
											<div class="price">
												<div class="num"><?=$order['price'][0];?></div>
												<div class="currency">
													<span><?=$order['price'][1];?></span>
													<i>грн</i>
												</div>
											</div>
											<div class="amount">
												<span>Кол-во</span>
												<label class="input-holder" style="background: none; border: none;">
                                                    <?
                                                    $portionslist=CHtml::listData($order->portions, 'value', 'value');

                                                    if(!in_array($order->quantity,$portionslist))
                                                        $portionslist=$portionslist+array($order->quantity=>$order->quantity);
                                                    asort($portionslist);
                                                    echo CHtml::dropDownList('portions', $order->quantity, $portionslist);?>
													<!--<input type="text" value="<?=$order->quantity;?>" />-->
												</label>
											</div>
										</div>
									</div>
								</li>
								<?}?>
								
							</ul>
							<div class="total-row">
								<div class="prices-all">
									<div id="totaloldprice" rel="<?=$totalCost;?>" class="price-holder">
										<span class="payable">К оплате при получении:</span>
										<div class="price">
											<?
											$oldlCost=$totalCost;
											$totalCost=explode('.',$totalCost);
											?>
											<div class="num"><?=$totalCost[0];?></div>
											<div class="currency">
												<span><?=$totalCost[1];?></span>
												<i>грн</i>
											</div>
										</div>
									</div>
									<?
									if($discount){
										$discountCost=$oldlCost/100*(100-$discount);
										$discountCost=explode('.',$discountCost);
                                        if(count($discountCost)>1)
                                        if(strlen($discountCost[1])==1)
                                        $discountCost[1]=$discountCost[1].'0';
                                    }
									?>
									<div<?=($discount)?' style="display:block"':'';?> id="discountblock" class="price-holder">
										<span class="payable">Скидка:</span>
										<div class="price">
											<div class="num">-<span id="percents"><?=$discount;?></span>%</div>
										</div>
									</div>

                                    <div style="display:none" id="discounttext" class="price-holder">
                                        <span class="payable"></span>
                                    </div>

									<div<?=($discount)?' style="display:block"':'';?> id="totalprice" class="price-holder">
										<span class="payable">К оплате co скидкой:</span>
										<div class="price">
											<div class="num"><?=(isset($discountCost[0]))?$discountCost[0]:00;?></div>
											<div class="currency">
												<span><?=(isset($discountCost[1]))?$discountCost[1]:00;?></span>
												<i>грн</i>
											</div>
										</div>
									</div>
									
								</div>
								<? if(!$userdiscount){?>
								<a href="#" class="green-btn promo-code-opener">
									<span>У меня есть промо-код</span>
								</a>
								<?}?>
							</div>
						</fieldset>
					</form>
				</div>
				<? if(Yii::app()->user->getId()>0){?>
				<div class="content-box">
					<div class="h1-holder">
						<div class="h1">Доставка и оплата</div>
					</div>
					<form  action="/cart/order/" method="post" class="delivery-form">
						<fieldset>
							<div class="form-box">
								<div class="row store">
									<div class="label-holder">
										<label>Имя</label>
									</div>
									<label class="input-holder">
										<input name="name" type="text" value="<?=($delivery_name)?$delivery_name:Yii::app()->user->getName();?>" />
									</label>
								</div>
								<div class="row required store">
									<div class="label-holder">
										<label>Телефон</label>
									</div>
									<label class="input-holder">
										<input name="phone" type="text" value="<?=($phone)?$phone:Yii::app()->user->getPhone();?>" />
									</label>
									<span class="req">&nbsp;</span>
								</div>
                                <div class="row store">
                                    <div class="row" style="margin:0;">
                                        <div class="label-holder">&nbsp;</div>
                                        <?=Chtml::dropDownList('deliveryplace_id',1,Deliveryplace::model()->active()->sort()->listData());?>
                                    </div>
                                </div>

                                <div class="delivery-blocks">
                                    <div class="row store">
                                        <div class="label-holder">
                                            <label>Доставим с</label>
                                        </div>
                                        <div class="time">
                                            <label class="input-holder">
                                                <input name="delivery_from" type="text" value="<?=($delivery_from)?$delivery_from:Yii::app()->user->getDeliveryFrom();?>" />
                                            </label>
                                            <span>до</span>
                                            <label class="input-holder">
                                                <input name="delivery_till" type="text" value="<?=($delivery_till)?$delivery_till:Yii::app()->user->getDeliveryTill();?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row store">
                                        <div class="label-holder">
                                            <label>По адресу</label>
                                        </div>
                                        <label class="textarea-holder">
                                            <textarea name="delivery_addr" cols="30" rows="5"><?=($delivery_addr)?$delivery_addr:Yii::app()->user->getDeliveryAddr();?></textarea>
                                        </label>
                                    </div>
                                </div>
								<div class="row" style="margin:-5px 0 6px;">
									<div class="label-holder">&nbsp;</div>
									<div class="required-description">Обязательные для заполнения поля</div>
								</div>
							</div>
                            <? if($_SERVER['REMOTE_ADDR']=='91.209.51.157'){?>
                                <?
                                $charities=Charity::model()->active()->sort()->findAll();
                                if($charities){
                                    ?>
                                    <div class="row" style="margin:-9px 0 11px;">
                                        <?
                                        foreach($charities as $charity){?>
                                            <div class="label-holder">&nbsp;</div>
                                            <input type="checkbox" name="charity[<?=$charity->id;?>]" id="char<?=$charity->id;?>" class="checkbox" value="<?=$charity->id;?>" />
                                            <label class="checkbox-label" for="char<?=$charity->id;?>"><?=$charity->title;?></label>
                                        <?}?>
                                    </div>
                                <?}
                                ?>
                            <?}?>
							<div class="form-box">
								<?
								$cnt=1;
								foreach($paytype as $pay){
								?>
								<div class="row" style="margin:-9px 0 11px;">
									<div class="label-holder">&nbsp;</div>
									<input type="radio" name="paytype_id" id="lbl<?=$pay->id;?>" class="radio"<?=($cnt==1)?' checked="checked"':'';?> value="<?=$pay->id;?>" />
									<label class="radio-label" for="lbl<?=$pay->id;?>"><?=$pay->title;?></label>
								</div>
								<?
								$cnt++;
								}?>

								<!--<div class="row" style="margin:0 0 7px;">
									<div class="label-holder">&nbsp;</div>
									<input type="radio" name="paytype_id" class="radio" value="2"/>
									<label class="radio-label" for="lbl2402">Оплатить через Интернет-кассу. Мы принимаем все ;) </label>
								</div>-->
								
								<div class="row">
									<div class="btn-holder right">
										<div class="red-btn">
											<span>Оформить заказ</span>
											<input onclick="_gaq.push(['_trackEvent','add','order']);" type="submit" value="Оформить заказ" />
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<?}else{?>
				<div class="content-box">
					<div class="h1-holder">
						<div class="h1">Доставка и оплата</div>
						<div class="link-holder">
							<a id="login_link" href="#">Я уже покупал ранее</a>
						</div>
					</div>
					<form action="/cart/order/" method="post" class="delivery-form">
						<fieldset>
							<div class="form-box">
								<div class="row store">
									<div class="label-holder">
										<label>Имя</label>
									</div>
									<label class="input-holder">
										<input name="name" type="text" value="<?=$delivery_name;?>" />
									</label>
								</div>
								<div class="row required store">
									<div class="label-holder">
										<label>Телефон</label>
									</div>
									<label class="input-holder">
										<input name="phone" type="text" value="<?=$phone;?>" />
									</label>
									<span class="req">&nbsp;</span>
								</div>
                                <div class="row store">
                                    <div class="row" style="margin:0;">
                                        <div class="label-holder">&nbsp;</div>
                                        <input type="checkbox" name="selfdeliver" id="selfdeliver"  class="radio" value="1" />
                                        <label class="radio-label" for="selfdeliver">самовывоз ул. Жилянская 59 "Дипломат Холл"</label>
                                    </div>
                                </div>
                                <div class="delivery-blocks">
                                    <div class="row store">
                                        <div class="label-holder">
                                            <label>Доставим с</label>
                                        </div>
                                        <div class="time">
                                            <label class="input-holder">
                                                <input type="text" name="delivery_from" value="<?=$delivery_from;?>" />
                                            </label>
                                            <span>до</span>
                                            <label class="input-holder">
                                                <input type="text" name="delivery_till" value="<?=$delivery_till;?>" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row store">
                                        <div class="label-holder">
                                            <label>По адресу</label>
                                        </div>
                                        <label class="textarea-holder">
                                            <textarea name="delivery_addr" cols="30" rows="5"><?=$delivery_addr;?></textarea>
                                        </label>
                                    </div>
                                </div>
								<div class="row" style="margin:-5px 0 6px;">
									<div class="label-holder">&nbsp;</div>
								</div>
							</div>
							<div class="form-box store">
								<div class="row" style="margin:-5px 0 16px;">
									<div class="label-holder">&nbsp;</div>
								</div>
								<div class="row required store">
									<div class="label-holder">
										<label>e-mail</label>
									</div>
									<label class="input-holder">
										<input type="text" name="email" value="<?=$email;?>"/>
									</label>
									<span class="req">&nbsp;</span>
								</div>
								<div class="row" style="margin:-4px 0 1px;">
									<div class="label-holder">&nbsp;</div>
									<div class="text-description">... или зарегистрируйтесь через Facebook</div>
								</div>
								<div class="row">
									<div class="label-holder">&nbsp;</div>
									<? $this->widget('common.extensions.yii-eauth.EAuthWidget', array('action' => 'site/loginoauth'));?>
								</div>
								<div class="row">
								    <div class="label-holder">&nbsp;</div>
								    <div class="required-description">Обязательно для заполнения</div><br/>
								<div>
							</div>
							<div class="form-box">
								<?
								$cnt=1;
								foreach($paytype as $pay){
								?>
								<div class="row" style="margin:-9px 0 11px;">
									<div class="label-holder">&nbsp;</div>
									<input id="lbl240<?=$pay->id;?>" type="radio" name="paytype_id" class="radio"<?=($cnt==1)?' checked="checked"':'';?> value="<?=$pay->id;?>" />
									<label class="radio-label" for="lbl240<?=$pay->id;?>"><?=$pay->title;?></label>
								</div>
								<?
								$cnt++;
								}?>
								<div class="row">
									<div class="btn-holder right">
										<div class="red-btn">
											<span>Оформить заказ</span>
											<input onclick="_gaq.push(['_trackEvent','add','order']);" type="submit" value="Оформить заказ" />
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<?}
				} else {?>
				<div id="content">
					<div class="content-box">
						<div class="content-block">
							<h1>Корзина</h1>
								Вы пока ничего не выбрали.<br>
								Но мы уверены,  вам обязательно что-то понравится в <a href="/#main">нашем меню</a> ;)
						</div>
					</div>
				</div>		
				<?}?>
			</div>
			<? if(count($topdishes)>0){?>
			<div id="sidebar">
				<div class="sidebar-box white">
					<h2>Добавить к заказу еще наборы?</h2>
					<? foreach($topdishes as $td){
					if(!isset($td->similar->portions[0]))
					continue;
					?>
					<div class="order-box">
						<p><a href="<?=$td->similar->getUrl();?>"><?=$td->similar->title;?></a></p>
						<div class="btn-holder right">
							<a onclick="_gaq.push(['_trackEvent','add','cart']);" href="/cart/add/<?=$td->similar->id;?>/?q=<?=$td->similar->portions[0]->value;?>" class="green-btn">
								<span>Добавить <?=$td->similar->portions[0]->value;?> <?=$this->intMorphy($td->similar->portions[0]->value,'порцию','порции','порций');?></span>
							</a>
						</div>
					</div>
					<?}?>
				</div>
			</div>
			<?}?>
			<? if(2<1){?>
			<div id="sidebar">
				<div class="sidebar-box white">
					<h2>Добавить к заказу еще наборы?</h2>
					<? foreach($topdishes as $td){
					if(!isset($td->portions[0]))
					continue;
					?>
					<div class="order-box">
						<p><a href="<?=$td->getUrl();?>"><?=$td->title;?></a></p>
						<div class="btn-holder right">
							<a onclick="_gaq.push(['_trackEvent','add','cart']);" href="/cart/add/<?=$td->id;?>/?q=<?=$td->portions[0]->value;?>" class="green-btn">
								<span>Добавить <?=$td->portions[0]->value;?> <?=$this->intMorphy($td->portions[0]->value,'порцию','порции','порций');?></span>
							</a>
						</div>
					</div>
					<?}?>
					
				</div>
			</div>
			<?}?>
		</div><!--main end-->