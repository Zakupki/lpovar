<div id="main"><!--main start-->
<div class="content-box">
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
                    <ul class="ingredients-list">
                        <? if(isset($course)){
                            $cnt=0;
                            foreach($course as $ctype){
                                if(isset($ctype->coursetype->dishtypeimage->file)){
                                    ?>
                                    <li>
                                        <?=$ctype->coursetype->dishtypeimage->asHtmlImage();;?>
                                    </li>
                                    <?
                                    if($cnt==1)
                                        break;
                                    $cnt++;
                                }
                            }
                        }?>
                    </ul>
                </div>
                <div class="text-box">
                    <h3><?=$course->title;?></h3>
                    <p><?nl2br($course->detail_text);?></p>
                </div>
                <div class="bottom-tools">
                    <?=$this->renderShare('/course/'.$course['id'].'/',$course->title);?>
                </div>
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
            //if(1==2)
            //foreach($course->courseIngredients as $cor){
            ?>
            <li>
                <ul class="ingredients">
                    <? foreach($course->courseIngredients as $ingredient){?>
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
                    <?}?>

                </ul>
                <div class="total-row">
                    <? if($course['calories']){?>
                        <div class="calories">калорийность 1 порции: <?=$course['calories'];?> калорий</div>
                    <?} if($course['weight']){?>
                        <span class="total-weight">выход блюда: <?=$course['weight'];?> гр</span>
                    <?}?>
                </div>
                <? //if(isset($order)){
                ?>
                <div class="btn-holder center">
                    <a href="<?=$course->getUrl();?>" class="red-btn big-btn"><span>Пошаговый фото и видеорецепт</span></a>
                </div>
                <?
                //}?>
            </li>
            <?//}?>
        </ul>

        <ul class="promo-list">
            <li>
                <a class="fancybox-thumb2 photo" rel="fancybox-thumb" href="/images/img_bag.jpg" title="Набор продуктов в фирменной упаковке">
                    <div class="img-holder">
                        <img src="/images/img28.png" width="102" height="139" alt="image description" />
                        <span class="photo-ico"></span>
                    </div>
                    <div class="name">Набор продуктов в фирменной упаковке</div>
                    <span class="deco"></span>
                </a>
            </li>
            <li>
                <a class="fancybox-thumb2 photo" rel="fancybox-thumb" href="/images/menu_example.jpg" title="Подробный рецепт">
                    <div class="img-holder">
                        <img src="/images/img29.png" width="107" height="139" alt="image description" />
                        <span class="photo-ico"></span>
                    </div>
                    <div class="name">Подробный рецепт</div>
                    <span class="deco"></span>
                </a>
            </li>
            <li>
                <div class="img-holder">
                    <a class="startvideo" target="_blank" href="/page/videorecipe"><img src="/images/img30.png" width="132" height="139" alt="image description" /></a>
                    <!--<span class="soon-ico"></span>-->
                </div>
                <div class="name"><a class="startvideo" target="_blank" href="/page/videorecipie">Видеоурок, доступный в вашем кабинете</a></div>
                <span class="deco"></span>
            </li>
        </ul>
    </div>
</div>
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