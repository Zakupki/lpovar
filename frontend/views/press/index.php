<div id="main"><!--main start-->
			<div id="content">
				<div class="content-box">
					<h1>Пресса о нас</h1>
					<ul class="lesson-list">
						<? foreach($items as $item){?>
						<li>
							<h3><a href="/press/<?=$item->id;?>/"><?=$item->title;?></a></h3>
							<p><?=$item->preview_text;?></p>
							<!--<div class="date">20 ноября 2014 / 22:00</div>-->
						</li>
						<?}?>
					</ul>
				</div>
			</div>
			<div id="sidebar">
				<?=$this->renderWidgets();?>
			</div>
		<div class="see-menu btn-holder center">
			<a href="/#top" class="green-btn">
				<span><?=Yii::t('frontend', 'Actualdish');?></span>
			</a>
		</div>
</div><!--main end-->