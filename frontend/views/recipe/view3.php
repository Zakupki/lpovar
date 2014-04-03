<div id="main"><!--main start-->
<div class="content-box recipe-box">
    <div class="item-box">
        <div class="item-row">
            <div class="recipe-gallery-holder">
                <div class="recipe-gallery">
                    <ul>
                        <?
                        if(isset($course->image)){?>
                            <li><img width="455" src="/<?=$course->image->path;?>/<?=$course->image->file;?>"/></li>
                        <?}else{?>
                            <li><img width="455" height="390" src="/images/zaglush.jpg" alt="<?=$course->title;?>"></li>
                        <?}?>
                    </ul>
                </div>
                <!--<div class="switcher">
                    <div class="switcher-box">
                        <ul>
                            <li><a class="active" href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                        </ul>
                    </div>
                </div>-->
            </div>

            <div class="recipe-frame">
                <div class="head">
                    <ul class="ingredients-list">
                        <?
                            if(isset($course->coursetype->dishtypeimage)){
                            ?>
                            <li>
                                <?=$course->coursetype->dishtypeimage->asHtmlImage();;?>
                            </li>
                            <?
                            }
                        ?>
                    </ul>
                </div>
                <div class="text-box">
                    <h3><?=$course->title;?></h3>
                    <p><?=nl2br($course->detail_text);?></p>
                </div>
                <div class="recipe-buttons">
                    <? if(isset($course->recipeimage)){?>
                    <div class="btn-holder">
                        <a href="/recipe/pdf?id=<?=$course->id;?>&print=1" target="_blank" class="lime-btn">
                            <span>Печать</span>
                        </a>
                    </div>
                        <?
                       // CVarDumper::dump($course->recipeimage->file,10,true);
                        ?>
                    <div class="btn-holder">
                        <a href="/recipe/pdf?id=<?=$course->id;?>" target="_blank" class="lime-btn">
                            <span>Скачать рецепт</span>
                        </a>
                    </div>
                    <?}?>
                    <? if($course->dish_id>0)
                    if($course->dish->status=1){?>
                    <div class="btn-holder">
                        <a href="/dish/<?=$course->dish_id;?>/" class="red-btn">
                            <span>Купить продукты</span>
                        </a>
                    </div>
                    <?}?>
                </div>
                <!--<div class="bottom-tools">
                    <?//$this->renderShare('/course/'.$course['id'].'/',$course->title);?>
                </div>-->
            </div>
        </div>
        <ul class="items">
            <?
            if(isset($course->cookware1)){
                ?>
                <li>
                    <?
                    //CVarDumper::dump($dish->cookware1->bigimage->attributes,10,true);
                    ?>
                    <?if(isset($dish->cookware1->image->file)){?>
                        <div class="img-holder">
                            <?=$dish->cookware1->image->asHtmlImage($dish->cookware1->title);?>
                        </div>
                    <?}?>
                    <div class="text">
                        <div class="num" style="color:white!important;">&nbsp;</div>
                        <? if(isset($dish->cookware1->bigimage)){?>
                        <script type="text/javascript">

                            $(function() {
                                // placement examples
                                $('.north').powerTip({ followMouse: true }).data('powertip', '<img src="/<?=$dish->cookware1->bigimage->path;?>/<?=$dish->cookware1->bigimage->file;?>"/>');
                            });
                        </script>
                        <a style="text-decoration:underline; color: #ba8154;" href="#" onclick="return false;" class="north" rel="fancybox-thumb" title="<?=$dish->cookware1->title;?>">
                            <strong>
                                <?}?>
                                <?=$dish->cookware1->title;?>
                                <? if(isset($dish->cookware1->bigimage)){?>
                                <a/>
                            </strong>
                            <?}?>
                    </div>
                </li>
            <?}
            if(isset($course->cookware2)){
                ?>
                <li>

                    <?if(isset($dish->cookware2->image->file)){?>
                        <div class="img-holder">
                            <?=$dish->cookware2->image->asHtmlImage($dish->cookware2->title);?>
                        </div>
                    <?}?>
                    <div class="text">
                        <div class="num" style="color:white!important;">&nbsp;</div>
                        <? if(isset($dish->cookware2->bigimage)){?>
                        <script type="text/javascript">
                            $(function() {
                                // placement examples
                                $('.north').powerTip({ followMouse: true }).data('powertip', '<img src="/<?=$dish->cookware2->bigimage->path;?>/<?=$dish->cookware2->bigimage->file;?>"/>');
                            });
                        </script>
                        <a style="text-decoration:underline; color: #ba8154;" href="#" onclick="return false;" class="north" rel="fancybox-thumb" title="<?=$dish->cookware2->title;?>">
                            <strong>
                                <?}?>
                                <?=$dish->cookware2->title;?>
                                <? if(isset($dish->cookware2->bigimage)){?>
                                <a/>
                            </strong>
                            <?}?>
                    </div>
                </li>
            <?}?>
        </ul>
        <ul class="menu-list mark2">
            <?
            $cnt=1;
            $half=ceil(count($course->courseIngredients)/2);
            foreach($course->courseIngredients as $ingredient){
                if($cnt==1){
                ?>
            <li>
                <ul class="ingredients">
                <?}elseif($cnt==$half+1){?>
                    </ul>
                </li>
                <li>
                    <ul class="ingredients">
                <?}?>
                        <li>
                            <div class="photo-box">
                                <? if($ingredient->ingredient->image['id']>0){?>
                                    <a class="fancybox-thumb photo" rel="fancybox-thumb" href="/<?=$ingredient->ingredient->image['path'].'/'.$ingredient->ingredient->image['file'];?>" title="<?=$ingredient->ingredient->title;?>"></a>
                                <?}else{?>
                                    <span class="nophoto"></span>
                                <?}?>
                            </div>
                            <div class="name"><?=$ingredient->ingredient->title;?></div>
                            <div class="weight"><?=$ingredient->value;?> <?=$ingredient->ingredient->dimension;?></div>
                        </li>
                <? if($cnt==count($course->courseIngredients)){?>
                <?}
                $cnt++;
                }
                ?>
                </ul>
                <div class="row">
                    <? if($course['weight']){?>
                    <div class="total-weight"><span class="title-text">выход 1 порции:</span><strong><?=$course['weight'];?></strong> гр.</div>
                    <?} if($course['calories']){?>
                    <div class="calories"><span class="title-text">калорийность 1 порции:</span><strong><?=$course['calories'];?></strong> калорий</div>
                    <?}?>
                </div>
            </li>
            <?
            ?>
        </ul>

    </div>
</div>
<? if(isset($videos) && count($videos)>0){?>
        <div class="video-box">
            <?  $cnt=0;
            $videoHtml='';
            $firsturl='';
            if(count($videos)>0)
            foreach($videos as $video){
                $vid=null;
                if($video->videotype_id==1){
                    $vid=$this->youtube_id_from_url(urldecode($video->url));
                    $videoHtml.='<li><a href="https://www.youtube.com/v/'.$vid.'?version=3&autoplay=1">'.$video->title.'</a></li>';
                    if(!$cnt)
                    $firsturl='https://www.youtube.com/v/'.$vid.'?version=3&autoplay=0';
                }elseif($video->videotype_id==2){
                    $vid=$this->vimeo_id_from_url(urldecode($video->url));
                    $videoHtml.='<li><a href="http://vimeo.com/moogaloop.swf?clip_id='.$vid.'&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=c27736&amp;fullscreen=1&amp;autoplay=0&amp;loop=0">'.$video->title.'</a></li>';
                    if(!$cnt)
                    $firsturl='http://vimeo.com/moogaloop.swf?clip_id='.$vid.'&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=c27736&amp;fullscreen=1&amp;autoplay=0&amp;loop=0';
                }?>
                <?
                $cnt++;
                ?>
                <!--<div class="video-frame">
                    <object width="640" height="370">
                        <param name="allowfullscreen" value="true">
                        <param name="allowscriptaccess" value="always">
                        <param name="movie" value="<?=$firsturl;?>">
                        <embed src="<?=$firsturl;?>" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="370" />
                    </object>
                </div>-->
            <?}?>

                        <div class="video-frame">
                            <object width="640" height="370">
                                <param name="allowfullscreen" value="true">
                                <param name="allowscriptaccess" value="always">
                                <param name="movie" value="<?=$firsturl;?>">
                                <embed src="<?=$firsturl;?>" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="370" />
                            </object>
                        </div>
            <ul class="video-list">
                <?=$videoHtml;?>
            </ul>
        </div>
<?}?>
<div class="content-box">
    <h1>Детальный рецепт приготовления</h1>
    <?
    foreach($course->steplist as $step){
        ?>
        <div class="step">
            <div class="img-holder">
                <?=$step->image->asHtmlImage();?>
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
        <?}?>
    <?}?>
</div>
<div class="recommend-box">
    <? if(count($dishes)>0){?>
        <div class="head">C этим блюдом Личный Повар рекомендует...</div>
        <ul class="recommend-list">
            <? foreach($dishes as $od){?>
                <li>
                    <? if(isset($od->similar->dishThumbs[1])){?>
                        <div class="img-holder"><a href="<?=$od->similar->getUrl();?>"><img src="/<?=$od->similar->dishThumbs[1]->thumb->path;?>/<?=$od->similar->dishThumbs[1]->thumb->file;?>" width="210" alt="image description" /></a></div>
                    <?}?>
                    <div class="info-row">
                        <span class="bottom-deco">&nbsp;</span>
                        <div class="info-frame">
                            <div class="title"><a href="<?=$od->similar->getUrl();?>">
                                    <?
                                    if(strlen($od->similar->title)>36){
                                        $od->similar->title=mb_substr(strip_tags($od->similar->title), 0, 33, 'UTF-8')."...";}
                                    echo $od->similar->title;
                                    ?></a></div>
                            <span class="price"><strong><?=$od->similar->price;?></strong> грн.</span>
                            <? if($od->similar->weight>0){?>
                                <span class="weight-text"><strong><?=$od->similar->weight*1000;?></strong> грамм</span>
                            <?}?>
                        </div>
                        <form action="/cart/add/<?=$od->similar->id;?>/" rel="<?=$od->similar->dishtype_id;?>" class="tools callbuy-popup2">
                            <fieldset>
                                <? if(isset($od->similar->portions[0])){?>
                                    <div class="row">
                                        <label class="input-holder">
                                            <input type="hidden" name="q" value="<?=$od->similar->portions[0]->value;?>"/>
                                            <input disabled="dosabled" class="callbuy-popup" type="text" value="<?=$od->similar->portions[0]->value;?>" />
                                        </label>
                                        <span class="control-label-text">шт.</span>
                                        <div class="btn-holder">
                                            <div class="green-btn">
                                                <span>Заказать</span>
                                                <input type="submit" value="Заказать" title="Заказать" />
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            </fieldset>
                        </form>
                    </div>
                </li>
            <?}?>

        </ul>
    <?}?>
</div>
<div class="see-menu btn-holder center">
    <a href="/#top" class="green-btn">
        <span><?=Yii::t('frontend', 'Actualdish');?></span>
    </a>
</div>
<!--popup end-->
<div class="popup-holder" id="video-popup"><!--popup start-->
    <div class="bg">&nbsp;</div>
    <div class="popup" style="width:560px; margin-left: -262px;">
        <div class="popup-frame" style="width:500px;">
            <p>
                <iframe src="http://player.vimeo.com/video/61950244" frameborder="0" width="500" height="281"></iframe>
                <br><br></p>
            <a href="#" class="close"></a>
        </div>
        <span class="popup-stroke" style="width:560px; bottom: 3px;"></span>
    </div>
</div><!--popup end-->
</div><!--main end-->