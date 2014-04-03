<div id="main"><!--main start-->
			<? if(!$ordereddishes){?>
			<div id="content">
				<div class="content-box">
					<div class="content-block">
						<h1>Заказы</h1>
							Вы пока ничего не заказывали.
					</div>
				</div>
			</div>		
			<?}?>
			<ul class="recipe-list"><!--recipe-list start-->
				<? foreach($ordereddishes as $tdish){?>
				<li>
					<div class="recipe-gallery-holder">
						<div class="recipe-gallery">
							<ul>
								<? foreach($tdish->dishImages as $image){?>
								<li><a href="<?=$tdish->getUrl();?>"><?=$image->image->asHtmlImage($tdish->title);?></a></li>
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
						<div class="description-row">Заказ №<?=$tdish->orderDishes[0]->order->id;?>, от <?=$tdish->orderDishes[0]->order->date_create;?>  / Цена <?=$tdish->orderDishes[0]->order->total;?> грн</div>
						<div class="text-box">
							<h3><a href="<?=$tdish->getUrl();?>"><?=$tdish->title;?></a></h3>
							<p><?=$tdish->detail_text;?></p>
						</div>
						<? if($tdish->orderDishes[0]->order->orderstate_id>2){?>
						<div class="bottom-tools">
							<div class="btn-holder">
								<a href="<?=$tdish->getUrl();?>" class="green-btn">
									<span>Рецепт приготовления</span>
								</a>
							</div>
						</div>
						<?}?>
					</div>
					<div style="clear:both;"></div>
				</li>
				<?}?>
			</ul><!--recipe-list end-->
			
		<div class="see-menu btn-holder center">
			<a href="/#top" class="green-btn">
				<span><?=Yii::t('frontend', 'Actualdish');?></span>
			</a>
		</div>
</div><!--main end-->