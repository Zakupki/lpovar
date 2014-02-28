		<div id="main"><!--main start-->
            <?
            if(isset($topdishes[0]->dishtype_id))
                if($topdishes[0]->dishtype_id==17){
                    echo '<img src="/images/cat_header_ny.png"/><br/><br/>';
                }
            ?>
            <? if(isset($topdishes[0]->dishtype->detail_text) && strlen($topdishes[0]->dishtype->detail_text)>0){?>
                <div class="category-header">
                    <div class="category-text"><?=$topdishes[0]->dishtype->detail_text;?></div>
                    <ul>
                        <li>Более 20 самых вкусных ресторанов Киева</li>
                        <li style="padding: 0 0 0 33px;">Уникальные рецепты от шеф-поваров</li>
                        <li>Лучшие ингредиенты</li>
                    </ul>
                </div>
            <?}?>
			<ul class="recipe-list product-list"><!--recipe-list start-->
				<? foreach($topdishes as $tdish){
				$tdish['price']=explode('.',$tdish['price']);
				?>
				<li>
                    <? if($tdish['new']){?>
                        <span class="news-label">Новинка</span>
                    <?}?>
					<div class="recipe-gallery-holder">
						<div class="recipe-gallery">
							<ul>
							<? 
							if(isset($tdish->image)){?>
                            <li><?=$tdish->image->asHtmlImage($tdish->title);?></li>
							<?}else{?>
						    <li><img width="280" height="240" src="/images/zaglush.jpg" alt="Омлет"></li>
							<?}?>
							</ul>
						</div>
					</div>
                    <div class="recipe-frame">
						<div class="head">
							<div class="btn-holder">
                                <!--<a data-cat="<?=$tdish->id;?>" rel="1" href="/cart/add/<?=$tdish->id;?>" class="to-cart callbuy-popup"></a>-->
								<a data-cat="<?=$tdish->id;?>" rel="1" href="/cart/add/<?=$tdish->id;?>" class="red-btn callbuy-popup">
									<span>Купить</span>
								</a>
							</div>
							<ul class="ingredients-list">
								<? if(isset($tdish->courses)){
									$cnt=0;
									foreach($tdish->courses as $course){
										if(isset($course->coursetype->coursetypeimage)){?>
											<li><?=$course->coursetype->coursetypeimage->asHtmlImage($course->coursetype->title);?></li>
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
							<h3><?=$tdish->title;?></h3>
							<p><?=$tdish->detail_text;?></p>
						</div>
						<div class="bottom-tools">
							<div class="price">
								<div class="num"><?=$tdish['price'][0];?></div>
								<div class="currency">
									<span><?=$tdish['price'][1];?></span>
									<i>грн</i>
								</div>
							</div>
						</div>
					</div>
				    <div style="clear:both;"></div>
                </li>
				<?}?>
			</ul><!--recipe-list end-->
			<?=$pages;?>
		</div><!--main end-->