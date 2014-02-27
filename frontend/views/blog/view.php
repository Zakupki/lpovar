<div class="blog-gallery-holder">
    <div class="blog-holder-content">
        <img src="/images/blog-header.png"/>
        <div class="blog-text">Выберите гастрономический набор, закажите бесплатную доставку специально подготовленных для него продуктов, добавьте щепотку вдохновения – и через полчаса изысканный ужин на двоих готов! Один набор – включает два блюда.</div>
    </div>
</div>
<div id="blog"><!--main start-->
    <div class="blogger">
        <div class="blogger-logo">
            <div class="blogger-round"></div>
            <?=$item->user->image->asHtmlImage();?>
        </div>
        <div class="blogger-text">
            <h3>Ваш Личный Блоггер</h3>
            <h2>Дмитрий Божок</h2>
            <p>Лазанья - национальное блюдо итальянской кухни. Тесто для неё готовится исключительно из твердых сортов пшениц. Правильное блюдо должно состоять как минимум из 4 слоёв теста с чередованием мясного соуса и соуса Бешамель. Лазанья - сочная и сытная, поэтому идеальным сочетанием к ней является витаминный салатный микс с помидорами черри и пармезаном...</p>
        </div>
    </div>
    <div id="content">
        <div class="content-box">
            <ul class="lesson-list">
                    <li>
                        <?
                        if(isset($item->image)){
                            echo $item->image->asHtmlImage($item->title);
                        }
                        ?>
                        <div class="blog-text">
                            <span class="blog-date"><?= Yii::app()->dateFormatter->formatDateTime($item->date_create, 'long', null); ?> / <?= Yii::app()->dateFormatter->formatDateTime($item->date_create, null, 'short'); ?> / <?=$item->user->email;?></span>
                            <h3><?=$item->title;?></h3>
                            <p><?=$item->detail_text;?></p>
                            <div class="btn-holder right">
                                <div class="blog-info">
                                    <span class="blog-views informer"><?=$item->views;?></span>
                                    <span class="blog-likes informer">0</span>
                                    <span class="blog-comments informer">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="fb-comments" data-href="http://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>" data-num_posts="2"  data-width="620"></div>
                    </li>
            </ul>
        </div>
    </div>
    <div id="sidebar">
        <ul class="catalog-list">
            <? foreach($dishes as $dish){?>
                <li>
                    <? if($dish->new){?>
                        <span class="news-label">Новинка</span>
                    <?}?>
                    <div class="img-holder">
                        <a href="<?=$dish->getUrl();?>">
                            <? if(isset($dish->dishImages[1]->image)){?>
                                <img src="/<?=$dish->dishImages[1]->image->path.'/'.$dish->dishImages[1]->image->file;?>" width="275" alt="Блюдо от комьюнити-шефа Алены Мищенко. Спагетти Карбонара">
                            <?}?>
                            <span class="mask">&nbsp;</span>
                        </a>
                        <? if(Option::getOpt('buy')){?>
                            <a data-cat="<?=$dish->dishtype_id;?>" rel="<?=(isset($dish->portions[0]->value))?$dish->portions[0]->value:1;?>" href="/cart/add/<?=$dish->id;?>/?q=<?=(isset($dish->portions[0]->value))?$dish->portions[0]->value:1;?>" class="to-cart callbuy-popup"></a>
                        <?}?>
                        <a href="<?=$dish->getUrl();?>" class="play"></a>
                    </div>
                    <div class="info-row">
                        <span class="bottom-deco">&nbsp;</span>
                        <div class="info-frame">
                            <div class="title"><a href="<?=$dish->getUrl();?>"><?=$dish->title;?></a></div>
                            <span class="price"><strong><?=$dish->price;?></strong> грн.</span>
                            <? if($dish->weight>0){?>
                                <span class="weight-text"><strong><?=$dish->weight*1000;?></strong> грамм</span>
                            <?}?>
                        </div>
                    </div>
                </li>
            <?}?>
        </ul>
    </div>
</div><!--main end-->
<div class="see-menu btn-holder center">
    <a href="/#top" class="green-btn">
        <span><?=Yii::t('frontend', 'Actualdish');?></span>
    </a>
</div>