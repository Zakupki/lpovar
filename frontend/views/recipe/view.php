<div id="main"><!--main start-->
<div class="content-box recipe-box">
    <div class="item-box">
        <div class="item-row">
            <div class="recipe-gallery-holder">
                <div class="recipe-gallery">
                    <ul>
                        <?
                        if(isset($course->image)){?>
                            <li><?=$course->image->asHtmlImage($course->title);?></li>
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
                    <div class="btn-holder">
                        <a href="" class="green-btn">
                            <span>Печать</span>
                        </a>
                    </div>
                    <div class="btn-holder">
                        <a href="" class="green-btn">
                            <span>Скачать рецепт</span>
                        </a>
                    </div>
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
<? if(isset($videos)){?>
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
                <div class="video-frame">
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
</div><!--main end-->
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