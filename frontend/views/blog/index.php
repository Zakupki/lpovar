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
            <?=$items[0]->user->image->asHtmlImage();?>
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
                <? foreach($items as $item){?>
                    <li>
                        <?
                        if(isset($item->image)){
                            echo $item->image->asHtmlImage($item->title);
                        }
                        ?>
                        <div class="blog-text">
                            <span class="blog-date"><?= Yii::app()->dateFormatter->formatDateTime($item->date_create, 'long', null); ?> / <?= Yii::app()->dateFormatter->formatDateTime($item->date_create, null, 'short'); ?> / <?=$item->user->email;?></span>
                            <h3><a href="/blog/<?=$item->id;?>/"><?=$item->title;?></a></h3>
                            <p><?=$item->preview_text;?></p>
                            <div class="btn-holder right">
                                <div class="blog-info">
                                    <span class="blog-views informer">0</span>
                                    <span class="blog-likes informer">0</span>
                                    <span class="blog-comments informer">0</span>
                                </div>
                                <a href="/blog/<?=$item->id;?>/" class="green-btn">
                                    <span>Читать далее</span>
                                </a>
                            </div>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
    <div id="sidebar">
        <?=$this->renderWidgets();?>
    </div>
</div><!--main end-->
<div class="see-menu btn-holder center">
    <a href="/#top" class="green-btn">
        <span><?=Yii::t('frontend', 'Actualdish');?></span>
    </a>
</div>