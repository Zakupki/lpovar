		<div id="main"><!--main start-->
			<div class="aside aside-fixed">
				<form action="/cart/add/<?=$dish->id;?>/" class="search">
					<fieldset>
						<div class="price-title">Цена одной порции</div>
						<?
						$intpart = floor($dish->price);
						$fraction = $dish->price - $intpart;
						$amount=1;
						?>
						<div class="price" rel="<?=$dish->price;?>">
							<div class="num"><?=$intpart;?></div>
							<div class="currency">
								<span><?=($fraction>0)?intval($fraction*100):'00';?></span>
								<i>грн</i>
							</div>
						</div>
						<ul class="num-list">
							<? 
							if(isset($dish->portions)){
							$cnt=0;
							foreach($dish->portions as $portion){?>
							<? if(!$cnt)
								$amount=$portion->value;
							?>
							<li<?=(!$cnt)?' class="active"':'';?>><input name="g0<?=$cnt+1;?>" type="radio"<?=(!$cnt)?' checked="checked"':'';?> /><a href="#" rel="<?=$portion->value;?>">
								<span class="text">&nbsp;&nbsp;</span>
								<span class="num"><?=$portion->value;?></span>
								<span class="text"><?=$this->intMorphy($portion->value,'порцию','порции','порций');?></span>
							</a></li>
							<?
							$cnt++;
							}}?>
						</ul>
						<div class="btn-holder">
							<a data-cat="<?=$dish->dishtype_id;?>" href="/cart/add/<?=$dish->id;?>/" rel="<?=$amount;?>" class="buy-btn callbuy-popup"><span>
								<strong>Купить</strong>
								<em><i><?=$amount;?></i> <?=$this->intMorphy($amount,'порцию','порции','порций');?></em>
							</span></a>
						</div>
						<div class="total">
							<div class="title">Итого к оплате</div>
							<strong><?=$dish->price*$amount;?></strong> грн.
						</div>
					</fieldset>
				</form>
			</div>
			<div class="content-frame">
            <? if($dish->new){?>
                <span class="news-label">Новинка</span>
            <?}?>
				<div class="content-box">
					<div class="item-box">
						<div class="item-head">
							<div class="complexity">
								<p>Уровень <br />сложности</p>
								<div class="stars">
									<strong><span style="width:<?=$dish->difficulty*33;?>%;"></span></strong>
								</div>
							</div>
							<ul class="ingredients-list">
								<li><img src="/<?=$dish->dishtype->dishtypeimage->path;?>/<?=$dish->dishtype->dishtypeimage->file;?>" width="55" height="44" alt="image description" /></li>
							</ul>
							<div class="title"><?=$dish->title;?></div>
						</div>
						<div class="visual-frame">
							<? if(isset($dish->dishImages[0]->image)){?>
							<div class="img-holder left">
								<span class="label">Мы привозим</span>
								<img src="/<?=$dish->dishImages[0]->image->path;?>/<?=$dish->dishImages[0]->image->file;?>" width="372" height="320" alt="image description" />
							</div>
							<?}if(isset($dish->dishImages[1]->image)){?>
							<div class="img-holder right">
								<span class="label">Вы готовите</span>
								<img src="/<?=$dish->dishImages[1]->image->path;?>/<?=$dish->dishImages[1]->image->file;?>" width="372" height="320" alt="image description" />
							</div>
							<?}?>
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
						<?
						$cnt=0;
						foreach($course as $cor){
						?>
						<div class="info-frame-box">
							<div class="recipe-text">
								<strong><?=$dish->title;?></strong><br/>
								<?=(!$cnt)?'<br>'.$dish->detail_text:'';?>
                                    <? if(isset($dish->shef)){?>
                                    <div class="cook-sign">
                                        <div class="img-holder round">
                                            <? if(isset($dish->shef->image)){?>
                                            <img width="150" height="150" src="<?='/'.$dish->shef->image->path.'/'.$dish->shef->image->file;?>" alt="">
                                            <?}?>
                                        </div>
                                        <div class="shef-block">
                                            <? if(isset($dish->shef->signature)){?>
                                            <img src="<?='/'.$dish->shef->signature->path.'/'.$dish->shef->signature->file;?>" alt="">
                                            <?}?>
                                            <p><?=$dish->shef->position;?></p>
                                            <p><strong><?=$dish->shef->name;?></strong></p>
                                        </div>
                                    </div>
                                    <?}?>
							</div>
							<div class="menu-list box">
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
								
								<div class="row">
									<?if($cor['weight']){?>
									<div class="total-weight"><span class="title-text">выход 1 порции:</span><strong><?=$cor['weight'];?></strong> гр.</div>
									<?} if($cor['calories']){?>
									<div class="calories"><span class="title-text">калорийность 1 порции:</span><strong><?=$cor['calories'];?></strong> калорий</div>
									<?}?>
								</div>
								
							</div>
						</div>
						<?
						$cnt++;
						}?>
						<div class="promo-list-title">Что Вы получите</div>
						<ul class="promo-list inner04">
						<li>
							<a class="fancybox-thumb2 photo" rel="fancybox-thumb" href="/images/img_bag.jpg?v=2" title="Набор продуктов в фирменной упаковке">
							<div class="img-holder">
								<img src="/images/img28.png" width="102" height="139" alt="image description" />
								<span class="photo-ico"></span>
							</div>
							<div class="name">Набор продуктов в фирменной упаковке</div>
							<span class="deco"></span>
							</a>
						</li>
						<li>
							<a class="fancybox-thumb2 photo" rel="fancybox-thumb" href="<?=(isset($dish->image))?'/'.$dish->image->path.'/'.$dish->image->file:'/images/img29.png';?>" title="Подробный рецепт">
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
								<a class="startvideo" target="_blank" href="#"><img src="/images/img30.png" width="132" height="139" alt="image description" /></a>
								<span class="watch-ico"></span>
							</div>
							<div class="name"><a class="startvideo" target="_blank" href="#">Видео-рецепт</a></div>
							<span class="deco"></span>
						</li>
					</ul>
						
					</div>
					<? //CVarDumper::dump($_SERVER,10,true);?>
					<div class="fb-comments" data-href="http://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" data-num_posts="2"  data-width="720"></div>
					
				</div>
			</div>
		</div><!--main end-->
        <div class="recommend-box">
            <? if(count($otherdishes)>0){?>
                <div class="head">C этим блюдом Личный Повар рекомендует...</div>
                <ul class="recommend-list">
                    <? foreach($otherdishes as $od){?>
                        <li>
                            <? if(isset($od->similar->dishThumbs[1])){?>
                                <div class="img-holder"><a href="<?=$od->similar->getUrl();?>"><img src="/<?=$od->similar->dishThumbs[1]->thumb->path;?>/<?=$od->similar->dishThumbs[1]->thumb->file;?>" width="210" alt="image description" /></a></div>
                            <?}?>
                            <div class="info-row">
                                <span class="bottom-deco">&nbsp;</span>
                                <div class="info-frame">
                                    <div class="title"><a href="<?=$od->similar->getUrl();?>">
                                            <?
                                            if(strlen($od->similar->title)>36){
                                                $od->similar->title=mb_substr(strip_tags($od->similar->title), 0, 33, 'UTF-8')."...";}
                                            echo $od->similar->title;
                                            ?></a></div>
                                    <span class="price"><strong><?=$od->similar->price;?></strong> грн.</span>
                                    <? if($od->similar->weight>0){?>
                                        <span class="weight-text"><strong><?=$od->similar->weight*1000;?></strong> грамм</span>
                                    <?}?>
                                </div>
                                <form action="/cart/add/<?=$od->similar->id;?>/" rel="<?=$od->similar->dishtype_id;?>" class="tools callbuy-popup2">
                                    <fieldset>
                                        <? if(isset($od->similar->portions[0])){?>
                                            <div class="row">
                                                <label class="input-holder">
                                                    <input type="hidden" name="q" value="<?=$od->similar->portions[0]->value;?>"/>
                                                    <input disabled="dosabled" class="callbuy-popup" type="text" value="<?=$od->similar->portions[0]->value;?>" />
                                                </label>
                                                <span class="control-label-text">шт.</span>
                                                <div class="btn-holder">
                                                    <div class="green-btn">
                                                        <span>Заказать</span>
                                                        <input type="submit" value="Заказать" title="Заказать" />
                                                    </div>
                                                </div>
                                            </div>
                                        <?}?>
                                    </fieldset>
                                </form>
                            </div>
                        </li>
                    <?}?>

                </ul>
            <?}?>
            <? if(count($tools)>0){?>
                <div class="head">Необходимые принадлежности...</div>
                <ul class="recommend-list">
                    <? foreach($tools as $od){?>
                        <li>
                            <? if(isset($od->tool->dishThumbs[0])){?>
                                <div class="img-holder"><img src="/<?=$od->tool->dishThumbs[0]->thumb->path;?>/<?=$od->tool->dishThumbs[0]->thumb->file;?>" width="210" alt="image description" /></div>
                            <?}?>
                            <div class="info-row">
                                <span class="bottom-deco">&nbsp;</span>
                                <div class="info-frame">
                                    <div class="title"><?
                                        if(strlen($od->tool->title)>38){
                                            $od->tool->title=mb_substr(strip_tags($od->tool->title), 0, 35, 'UTF-8')."...";}
                                        echo $od->tool->title;
                                        ?></div>
                                    <span class="price"><strong><?=$od->tool->price;?></strong> грн.</span>
                                    <? if($od->tool->weight>0){?>
                                        <span class="weight-text"><strong><?=$od->tool->weight*1000;?></strong> грамм</span>
                                    <?}?>
                                </div>
                                <form action="/cart/add/<?=$od->tool->id;?>/" class="tools">
                                    <fieldset>
                                        <div class="row">
                                            <label class="input-holder">
                                                <input disabled="dosabled" type="text" value="1" />
                                            </label>
                                            <span class="control-label-text">шт.</span>
                                            <div class="btn-holder">
                                                <div class="green-btn">
                                                    <span>Заказать</span>
                                                    <input type="submit" value="Заказать" title="Заказать" />
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </li>
                    <?}?>

                </ul>
            <?}?>
        </div>
		<div class="popup-holder" id="video-popup"><!--popup start-->
                        <div class="bg">&nbsp;</div>
                        <div class="popup" style="width:560px; margin-left: -262px;">
                            <div class="popup-frame" style="width:500px;">
                                <p>

                                 <br><br></p>
                                <a href="#" class="close"></a>
                            </div>
                            <div class="popup-videodata" style="display: none">
                                    <?=$dish->video;?><br><br>
                            </div>

                            <span class="popup-stroke" style="width:560px; bottom: 3px;"></span>
                        </div>
         </div><!--popup end-->