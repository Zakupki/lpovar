<div id="main"><!--main start-->
			<div class="content-box">
				<div class="content-head">
					<div class="recipte-name"><?=$course->dish->title;?></div>
					<h1><?=$course->title;?></h1>
					<div class="description">Детальный рецепт приготовления</div>
				</div>
				<? if($videos){?>
				<div class="video-box">
					<?  $cnt=0;
						$videoHtml='';
						foreach($videos as $video){
						$vid=null;
						
						if($video->videotype_id==1){
							$vid=$this->youtube_id_from_url(urldecode($video->url));
							$videoHtml.='<li><a href="https://www.youtube.com/v/'.$vid.'?version=3&autoplay=1">'.$video->title.'</a></li>';
							$firsturl='https://www.youtube.com/v/'.$vid.'?version=3&autoplay=0';
						}elseif($video->videotype_id==2){
							$vid=$this->vimeo_id_from_url(urldecode($video->url));	
							$videoHtml.='<li><a href="http://vimeo.com/moogaloop.swf?clip_id='.$vid.'&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=c27736&amp;fullscreen=1&amp;autoplay=0&amp;loop=0">'.$video->title.'</a></li>';
				            $firsturl='http://vimeo.com/moogaloop.swf?clip_id='.$vid.'&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=c27736&amp;fullscreen=1&amp;autoplay=0&amp;loop=0';
						}?>	
					<?
						$cnt++;
					?>
					<div class="video-rame">
						<object width="640" height="370">
							<param name="allowfullscreen" value="true">
							<param name="allowscriptaccess" value="always">
							<param name="movie" value="<?=$firsturl;?>">
							<embed src="<?=$firsturl;?>" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="370" />
						</object>
					</div>	
					<?}?>
					
					<!--<div class="video-frame">
						<object width="640" height="370">
							<param name="allowfullscreen" value="true">
							<param name="allowscriptaccess" value="always">
							<param name="movie" value="<?=$firsturl;?>">
							<embed src="<?=$firsturl;?>" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="370" />
						</object>
					</div>-->
					<!--<ul class="video-list">
						<?=$videoHtml;?>
					</ul>-->
				</div>
				<?}
				if(isset($course->recipe))
				echo $course->recipe->asHtmlImage();
                foreach($steps as $step){
				?>
				<div class="step">
					<div class="img-holder">
							<? if(isset($step->image)){
							echo $step->image->asHtmlImage();
							}?>
					</div>
					<div class="text">
						<h2>Шаг <?=$step['step'];?></h2>
						<div class="title"><?=$step['preview_text'];?></div>
						<p><?=$step['detail_text'];?></p>
					</div>
				</div>
				<? if(strlen($step['advice'])>0 && $step->user['id']>0){?>
				<div class="advice">
					<div class="img-holder round">
						<? if(isset($step->user->image)){
						echo $step->user->image->asHtmlImage();
						}?>
						<!--<img src="/images/img32.jpg" width="172" height="172" alt="image description" />-->
					</div>
					<div class="advice-frame">
						<div class="title">Шеф-совет</div>
						<p>«<?=$step['advice'];?>»</p>
						<div class="name"><em>Ваш личный повар, <?=$step->user['name'];?></em></div>
						<span class="deco"></span>
					</div>
				</div>
				<?}}?>
				
				<!--<div class="step">
					<div class="img-holder">
						<a href="#"><img src="/images/img31.png" width="455" height="390" alt="image description" /></a>
					</div>
					<div class="text">
						<h2>Шаг 1</h2>
						<div class="title">Вам понадобится: Стейк лосося - 300г, Моцарелла - 30г, Соус Песто, 20г</div>
						<p>Изысканное ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом. Изысканное ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом ..обеспечит приятный вечер ризотто с овощами порадует вас </p>
					</div>
				</div>
				<div class="advice">
					<div class="img-holder round">
						<img src="/images/img32.jpg" width="172" height="172" alt="image description" />
					</div>
					<div class="advice-frame">
						<div class="title">Шеф-совет</div>
						<p>«Была на мастер-классе по приготовлению лазаньи, осталась в полном восторге. Это просто фантастически. Я так никогда вкусно еще не готовила. Шеф-повар, Алексей просто гениальный повар. Была на мастер-классе по приготовлению лазаньи, осталась в полном восторге. Это просто фантастически. Я так никогда вкусно еще не готовила. »</p>
						<div class="name"><em>Ваш личный повар, Юрий Рожков</em></div>
						<span class="deco"></span>
					</div>
				</div>
				<div class="step">
					<div class="img-holder">
						<a href="#"><img src="/images/img31.png" width="455" height="390" alt="image description" /></a>
					</div>
					<div class="text">
						<h2>Шаг 1</h2>
						<div class="title">Вам понадобится: Стейк лосося - 300г, Моцарелла - 30г, Соус Песто, 20г</div>
						<p>Изысканное ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом. Изысканное ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом и обеспечит приятный вечер ризотто с овощами порадует вас особенно нежным вкусом ..обеспечит приятный вечер ризотто с овощами порадует вас </p>
					</div>
				</div>-->
				<div class="btn-holder center" style="padding:16px 0 11px;">
					<a href="/dish/<?=$course->dish->id;?>/" class="green-btn big-btn"><span>Вернуться в набор</span></a>
				</div>
			</div>
		</div>