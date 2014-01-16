		<div id="main"><!--main start-->
			<ul class="recipe-list"><!--recipe-list start-->
				<? foreach($topdishes as $tdish){
				?>
				<li>
					<div class="recipe-gallery-holder">
						<div class="recipe-gallery">
							<ul>
							<? 
							if($tdish->image){?>
								<li>
                                    <? if(strlen($tdish->link)>0){?><a target="_blank" href="<?=$tdish->link;?>"><?}?>
                                    <?=$tdish->image->asHtmlImage($tdish->title);?>
                                    <? if(strlen($tdish->link)>0){?></a><?}?>
                                </li>
							<?}else{?>
								<li><img width="455" height="390" src="/images/zaglush.jpg" alt="<?=$tdish->title;?>"></li>
							<?}?>
							</ul>
						</div>
					</div>
					<div class="recipe-frame">
						<div class="text-box">
							<h3><?=$tdish->title;?></h3>
							<p><?=$tdish->preview_text;?></p>
						</div>
					</div>
					<div style="clear:both;"></div>
				</li>
				<?}?>
				
				
				
			</ul><!--recipe-list end-->
			<?=$pages;?>
		</div><!--main end-->