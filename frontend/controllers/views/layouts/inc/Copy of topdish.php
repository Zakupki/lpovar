				<?
				//if(isset($this->dishtype_id)){
				//echo $this->dishtype_id;
				//}
				?>
				<ul class="tisers-list catalog">
					<? 
					$cnt=1;
					$class=array();
					foreach($tdishes as $dish){
					$class[$cnt]='';
					if($cnt==count($tdishes)){
						$class[$cnt]=' class="last"';
						if(isset($this->dishtype_id))
						if($this->dishtype_id==$dish->id)
						$class[$cnt]=' class="last active"';	
						
					}else
						if(isset($this->dishtype_id))
						if($this->dishtype_id==$dish->id)
						$class[$cnt]=' class="active"';					
						
					?>
					<li<?=$class[$cnt];?>>
						<a href="/dish/category/<?=$dish->id;?>">
							<?
				            if(strlen($dish->title)>34){
				            $dish->title=mb_substr(strip_tags($dish->title), 0, 31, 'UTF-8')."...";}
				            ?> 
							<span class="text"><?=$dish->title;?></span>
							<em class="num"><?=count($dish->dishes);?> <?=$this->intMorphy(count($dish->dishes),'набор','набора','наборов');?></em>
							<span class="img-holder">
								<?
								if(isset($dish->dishtypeimage)){
									echo $dish->dishtypeimage->asHtmlImage($dish->title);
								}
								?>
							</span>
						</a>
					</li>
					<?
					$cnt++;
					}
					?>
			</ul>