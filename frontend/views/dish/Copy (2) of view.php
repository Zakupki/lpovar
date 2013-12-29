<div id="main"><!--main start-->
			<div class="content-box">
				<div class="item-box">
					<div class="item-row">
						<div class="recipe-gallery-holder">
							<div class="recipe-gallery">
								<ul>
									<? $dish['price']=explode('.',$dish['price']);
									if(isset($dish->dishImages)){
									foreach($dish->dishImages as $image){?>
										<li><?=$image->image->asHtmlImage($dish->title);?></li>
									<?}}else{?>
										<li><a href="<?=$dish->getUrl();?>"><img width="455" height="390" src="/images/zaglush.jpg" alt="Омлет"></a></li>
									<?}?>
								</ul>
							</div>
							<div class="switcher">
								<div class="switcher-box">
									<ul>
										<li><a class="active" href="#"></a></li>
										<li><a href="#"></a></li>
										<li><a href="#"></a></li>
										<li><a href="#"></a></li>
									</ul>
								</div>
							</div>
							<i class="dish4-<?=$dish['persons'];?>"></i>
						</div>
						
						<div class="recipe-frame">
							<div class="head">
								<? if($dish->main==1){?>
								<div class="btn-holder">
									<a onclick="_gaq.push(['_trackEvent','add','cart']);" href="/cart/add/<?=$dish->id;?>/" class="red-btn">
										<span>Купить</span>
									</a>
								</div>
								<?}?>
								<ul class="ingredients-list">
									<? if(isset($course)){
									$cnt=0;	
									foreach($course as $ctype){
									if(isset($ctype->coursetype->dishtypeimage->file)){
									?>
									<li>
										<?=$ctype->coursetype->dishtypeimage->asHtmlImage();;?>
									</li>
									<?
									if($cnt==1)
									break;
									$cnt++;
									}
									}
									}?>
								</ul>
							</div>
							<div class="text-box">
								<h3><?=$dish->title;?></h3>
								<p><?=nl2br($dish->detail_text);?></p>
							</div>
							<div class="bottom-tools">
								<div class="price">
									<div class="num"><?=$dish['price'][0];?></div>
									<div class="currency">
										<span><?=$dish['price'][1];?></span>
										<i>грн</i>
									</div>
								</div>
								<?=$this->renderShare('/dish/'.$dish['id'].'/',$dish->title);?>
							</div>
						</div>
					</div>
					<ul class="items">
						<? if($dish->prepare>0){?>
						<li>
							<div class="img-holder">
								<img src="/images/img24.png" width="127" height="101" alt="image description" />
							</div>
							<div class="text">
								<div class="num"><?=$dish->prepare;?></div>
								минут на приготовление
							</div>
						</li>
						<?} 
						if($dish->steps>0){?>
						<li>
							<div class="img-holder">
								<img src="/images/img25.png" width="104" height="103" alt="image description" />
							</div>
							<div class="text">
								<div class="num"><?=$dish->steps;?></div>
								простых шагов
							</div>
						</li>
						<?}?>
						<?
						if(isset($dish->cookware1)){
						?>
						<li>
						    <?
						    //CVarDumper::dump($dish->cookware1->bigimage->attributes,10,true);
						    ?>
							<?if(isset($dish->cookware1->image->file)){?>
							<div class="img-holder">
								<?=$dish->cookware1->image->asHtmlImage($dish->cookware1->title);?>
							</div>
							<?}?>
							<div class="text">
								<div class="num" style="color:white!important;">&nbsp;</div>
								<? if(isset($dish->cookware1->bigimage)){?>
                                <script type="text/javascript">
                                
                                $(function() {
                                    // placement examples
                                    $('.north').powerTip({ followMouse: true }).data('powertip', '<img src="/<?=$dish->cookware1->bigimage->path;?>/<?=$dish->cookware1->bigimage->file;?>"/>');
                                });
                                </script>    
                                <a style="text-decoration:underline; color: #ba8154;" href="#" onclick="return false;" class="north" rel="fancybox-thumb" title="<?=$dish->cookware1->title;?>">
                                <strong>
                                <?}?>
                                <?=$dish->cookware1->title;?>
                                <? if(isset($dish->cookware1->bigimage)){?>
                                <a/>
                                </strong>
                                 <?}?>
							</div>
						</li>
						<?}
						if(isset($dish->cookware2)){
						?>
						<li>
                            
                            <?if(isset($dish->cookware2->image->file)){?>
                            <div class="img-holder">
                                <?=$dish->cookware2->image->asHtmlImage($dish->cookware2->title);?>
                            </div>
                            <?}?>
                            <div class="text">
                                <div class="num" style="color:white!important;">&nbsp;</div>
                                <? if(isset($dish->cookware2->bigimage)){?>
                                <script type="text/javascript">
                                $(function() {
                                    // placement examples
                                    $('.north').powerTip({ followMouse: true }).data('powertip', '<img src="/<?=$dish->cookware2->bigimage->path;?>/<?=$dish->cookware2->bigimage->file;?>"/>');
                                });
                                </script>    
                                <a style="text-decoration:underline; color: #ba8154;" href="#" onclick="return false;" class="north" rel="fancybox-thumb" title="<?=$dish->cookware2->title;?>">
                                <strong>
                                <?}?>
                                <?=$dish->cookware2->title;?>
                                <? if(isset($dish->cookware2->bigimage)){?>
                                <a/>
                                </strong>
                                 <?}?>
                            </div>
                        </li>
						<?}?>
					</ul>
					<ul class="menu-list mark2">
						<?
						foreach($course as $cor){
						?>
						<li>
							<div class="head">
								<div class="photo-box">
									<? if($cor->image['id']>0){?>
									
									<a class="fancybox-thumb photo" rel="fancybox-thumb" href="/<?=$cor->image['path'].'/'.$cor->image['file'];?>" title="<?=$cor['title'];?>"></a>
									<?}else{?>
									<span class="nophoto"></span>
									<?}?>
								</div>
								<div class="title"><?=$cor['title'];?></div>
							</div>
							
							<ul class="ingredients">
								<? foreach($cor->courseIngredients as $ingredient){?>
								<li>
									<div class="photo-box">
										<? if($ingredient->ingredient->image['id']>0){?>
										<a class="fancybox-thumb photo" rel="fancybox-thumb" href="/<?=$ingredient->ingredient->image['path'].'/'.$ingredient->ingredient->image['file'];?>" title="<?=$ingredient->ingredient->title;?>"></a>
										<?}else{?>
										<span class="nophoto"></span>
										<?}?>
									</div>
									<div class="name"><?=$ingredient->ingredient->title;?></div>
									<div class="weight"><?=$ingredient->value;?> <?=$ingredient->ingredient->dimension;?></div>
								</li>
								<?}?>
								
							</ul>
							<div class="total-row">
								<? if($cor['calories']){?>
								<div class="calories">калорийность 1 порции: <?=$cor['calories'];?> калорий</div>
								<?} if($cor['weight']){?>
								<span class="total-weight">выход блюда: <?=$cor['weight'];?> гр</span>
								<?}?>
							</div>
							<? //if(isset($order)){
							?>
							<div class="btn-holder center">
								<a href="<?=$cor->getUrl();?>" class="red-btn big-btn"><span>Пошаговый фото и видеорецепт</span></a>
							</div>
							<?
                            //}?>
						</li>
						<?}?>
					</ul>
					
					<ul class="promo-list">
						<li>
							<a class="fancybox-thumb2 photo" rel="fancybox-thumb" href="/images/img_bag.jpg" title="Набор продуктов в фирменной упаковке">
							<div class="img-holder">
								<img src="/images/img28.png" width="102" height="139" alt="image description" />
								<span class="photo-ico"></span>
							</div>
							<div class="name">Набор продуктов в фирменной упаковке</div>
							<span class="deco"></span>
							</a>
						</li>
						<li>
							<a class="fancybox-thumb2 photo" rel="fancybox-thumb" href="/images/menu_example.jpg" title="Подробный рецепт">
							<div class="img-holder">
								<img src="/images/img29.png" width="107" height="139" alt="image description" />
								<span class="photo-ico"></span>
							</div>
							<div class="name">Подробный рецепт</div>
							<span class="deco"></span>
							</a>
						</li>
						<li>
							<div class="img-holder">
								<a class="startvideo" target="_blank" href="/page/videorecipe"><img src="/images/img30.png" width="132" height="139" alt="image description" /></a>
								<!--<span class="soon-ico"></span>-->
							</div>
							<div class="name"><a class="startvideo" target="_blank" href="/page/videorecipie">Видеоурок, доступный в вашем кабинете</a></div>
							<span class="deco"></span>
						</li>
					</ul>
					<? if($dish->main==1){?>
					<div class="total-box">
						<div class="text">Стоимость набора для двоих:</div>
						<div class="price">
							<div class="num"><?=$dish['price'][0];?></div>
							<div class="currency">
								<span><?=$dish['price'][1];?></span>
								<i>грн</i>
							</div>
						</div>
						<div class="btn-holder center">
							<a onclick="_gaq.push(['_trackEvent','add','cart']);"  href="/cart/add/<?=$dish->id;?>/" class="red-btn"><span>Купить</span></a>
						</div>
					</div>
					<?}?>
					
				</div>
			</div>
			<!--<div class="video-box">
				<div class="video-frame">
					<img src="/images/video.png" width="640" height="370" alt="image description" />
				</div>
				<ul class="video-list">
					<? foreach($videos as $video){?>
					<li><a href="#"><?=$video['title'];?></a></li>
					<?}?>
				</ul>
			</div>
			<? if(count($steps)>0){?>
			<div class="content-box">
				<h1>Детальный рецепт приготовления</h1>
				<?
				foreach($steps as $step){
				?>
				<div class="step">
					<div class="img-holder">
						<a href="#">
							<?=$step->image->asHtmlImage();?>
						</a>
					</div>
					<div class="text">
						<h2>Шаг <?=$step['step'];?></h2>
						<div class="title"><?=$step['preview_text'];?></div>
						<p><?=$step['detail_text'];?></p>
					</div>
				</div>
				<?}?>
			</div>
			<?}?>-->
		</div><!--main end-->
		<div class="see-menu btn-holder center">
			<a href="/#top" class="green-btn">
				<span><?=Yii::t('frontend', 'Actualdish');?></span>
			</a>
		</div>
		 <!--popup end-->
         <div class="popup-holder" id="video-popup"><!--popup start-->
                        <div class="bg">&nbsp;</div>
                        <div class="popup" style="width:560px; margin-left: -262px;">
                            <div class="popup-frame" style="width:500px;">
                                <p>
                                    <iframe src="http://player.vimeo.com/video/61950244" frameborder="0" width="500" height="281"></iframe>
                                 <br><br></p>
                                <a href="#" class="close"></a>
                            </div>
                            <span class="popup-stroke" style="width:560px; bottom: 3px;"></span>
                        </div>
         </div><!--popup end-->