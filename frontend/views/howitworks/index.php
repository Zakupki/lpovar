		<div id="main"><!--main start-->
			<div id="content" class="content-how">
				<div class="content-box">
					<h1>Как это работает</h1>
					<ul class="how-list"><!--recipe-list start-->
						<? 
						$cnt=1;
						$tcnt=1;
						foreach($topdishes as $tdish){
						?>
						<li class="how-<?=($cnt==1)?'l':'r';?>">
							<div class="how-image-holder">
									<? 
									if($tdish->image){?>
										<?=$tdish->image->asHtmlImage($tdish->title);?>
									<?}?>
							</div>
							<div class="how-frame">
								<div class="text-box">
									<h3><?=$tdish->title;?></h3>
									<p><?=$tdish->description;?></p>
								</div>
							</div>
							<div class="how-arrow<?=($tcnt==count($topdishes))?' how-arrow-last':'';?>">
							</div>
							<div style="clear:both;"></div>
						</li>
						<?
						$cnt++;
						$tcnt++;
						if($cnt==3)
						$cnt=1;
						}?>
					</ul>
				</div>
			</div>
			<div class="stamps-content">
					<ul>
						<li>
							<img src='/images/stamp-delivery.png'/>
						</li>
						<li>
							<img src='/images/stamp-fresh.png'/>
						</li>
						<li>
							<img src='/images/stamp-original.png'/>
						</li>
						<li>
							<img src='/images/stamp-portions.png'/>
						</li>
					</ul>
				</div>
		</div><!--main end-->
		<div class="see-menu btn-holder center">
			<a href="/#top" class="green-btn">
				<span><?=Yii::t('frontend', 'Actualdish');?></span>
			</a>
		</div>