		<div id="main"><!--main start-->
			<div id="content">
				<div class="content-box">
					<h1><?=$page['title'];?></h1>
					<? if(isset($page->image->file)){?>
					<div class="visual-box" style="margin-bottom:10px;">
						<?=$page->image->asHtmlImage($page->title);?>
					</div>
					<?}?>
					<div class="content-block">
							<p><?=$page['detail_text'];?></p>
							<? if($page['link']){?>
							<p><br/>
								Источник: 
								<a target="_blank" href="http://<?=str_replace(array('http://','https://'), '', $page['link'])?>"><?=$page['link'];?></a></p>
							<?}?>
					</div>
				</div>
			</div>
			<?=$this->renderWidgets($page->id);?>
		</div><!--main end-->
		<div class="see-menu btn-holder center">
			<a href="/#top" class="green-btn">
				<span><?=Yii::t('frontend', 'Actualdish');?></span>
			</a>
		</div>