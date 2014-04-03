		<div id="main"><!--main start-->
            <ul class="recipe-list"><!--recipe-list start-->
                <? foreach($topdishes as $tdish){?>
                    <li>
                        <div class="recipe-gallery-holder">
                            <div class="recipe-gallery">
                                <ul>
                                    <?
                                    if($tdish->image){?>
                                        <li><a href="<?=$tdish->getUrl('recipe');?>"><img width="455" src="/<?=$tdish->image->path;?>/<?=$tdish->image->file;?>"/></a></li>
                                    <?}else{?>
                                        <li><a href="<?=$tdish->getUrl('recipe');?>"><img width="455" height="390" src="/images/zaglush.jpg" alt="Омлет"></a></li>
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
                        </div>
                        <div class="recipe-frame">
                            <div class="head">
                                <div class="btn-holder">
                                    <a href="<?=$tdish->getUrl('recipe');?>" class="lime-btn">
                                        <span>Cмотреть рецепт</span>
                                    </a>
                                </div>
                                <ul class="ingredients-list">

                                </ul>
                            </div>
                            <div class="text-box">
                                <h3><a href="<?=$tdish->getUrl('recipe');?>"><?=$tdish->title;?></a></h3>
                                <p><?=nl2br($tdish->preview_text);?></p>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </li>
                <?}?>
            </ul>
			<?=$pages;?>
		</div><!--main end-->