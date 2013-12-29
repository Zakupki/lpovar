		<div id="main"><!--main start-->

            <?
            if(isset($topdishes[0]->dishtype_id))
                if($topdishes[0]->dishtype_id==17){
                    echo '<img src="/images/cat_header_ny.png"/><br/><br/>';
                }
            //echo $topdishes[0]->dishtype_id;
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
			<ul class="recipe-list"><!--recipe-list start-->
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
							if($tdish->dishImages){
                            //foreach($tdish->dishImages as $image){?>

								<? if(isset($tdish->dishImages[1])){?>
                                <li><a href="<?=$tdish->getUrl();?>"><?=$tdish->dishImages[1]->image->asHtmlImage($tdish->title);?></a></li>
                                <?}if(isset($tdish->dishImages[0])){?>
                                    <li><a href="<?=$tdish->getUrl();?>"><?=$tdish->dishImages[0]->image->asHtmlImage($tdish->title);?></a></li>
							<?}
                            //}
                            }else{?>
								<li><a href="<?=$tdish->getUrl();?>"><img width="455" height="390" src="/images/zaglush.jpg" alt="Омлет"></a></li>
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
						<!--<i class="dish4-<?=$tdish['persons'];?>"></i>-->
					</div>
                    <div class="recipe-frame">
						<div class="head">
							<div class="btn-holder">
								<a href="<?=$tdish->getUrl();?>" class="green-btn">
									<span>Смотреть</span>
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
							<h3><a href="<?=$tdish->getUrl();?>"><?=$tdish->title;?></a></h3>
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
							<?=$this->renderShare('/dish/'.$tdish['id'].'/',$tdish->title);?>
						</div>
					</div>
				    <div style="clear:both;"></div>
                </li>
				<?}?>
				
				
				
			</ul><!--recipe-list end-->
			<?=$pages;?>
		</div><!--main end-->