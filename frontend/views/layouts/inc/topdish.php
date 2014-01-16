				<?
				//if(isset($this->dishtype_id)){
				//echo $this->dishtype_id;
				//}
				?>
				<ul class="tisers-list catalog">
					<? 
					$cnt=1;
					$class=array();
					foreach($tdishes['types'] as $dish){
					$class[$cnt]='';
					if($cnt==count($tdishes['types'])){
						$class[$cnt]=' class="last"';
						if(isset($this->dishtype_id))
						if($this->dishtype_id==$dish['id'])
						$class[$cnt]=' class="last active"';	
						
					}else
						if(isset($this->dishtype_id))
						if($this->dishtype_id==$dish['id'])
						$class[$cnt]=' class="active"';					
						
					?>
					<li<?=$class[$cnt];?><?=($dish['id']==18)?' id="main-submenu"':'';?>>
						<a href="/dish/category/<?=$dish['id'];?>">
							<?
				            if(strlen($dish['title'])>34){
				            $dish['title']=mb_substr(strip_tags($dish['title']), 0, 31, 'UTF-8')."...";}

                            $othercount=0;
                            if($dish['id']==18 && isset($tdishes['other'])){
                            foreach($tdishes['other'] as $other)
                                    $othercount=$othercount+$other['cnt'];
                            $dish['cnt']=$othercount;
                            }
                            ?>
							<span class="text"><?=$dish['title'];?></span>
							<em class="num"><?=$dish['cnt'];?> <?=$this->intMorphy($dish['cnt'],'набор','набора','наборов');?></em>
							<span class="img-holder">
								<img src="<?=$dish['image'];?>"/>
                            </span>
						</a>
                        <? if($dish['id']==18 && isset($tdishes['other'])){?>
                            <ul>
                                <li class="submenu-start"></li>
                                <? foreach($tdishes['other'] as $other){?>
                                <li><a href="/product/category/<?=$other['id'];?>"><?=$other['title'];?></a></li>
                                <?}?>
                                <li class="submenu-end"></li>
                            </ul>
                        <?}?>
					</li>
					<?
					$cnt++;
					}
					?>
			</ul>