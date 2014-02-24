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
        <ul class="catalog-list">
            <li>
                <div class="img-holder">
                    <a href="/product/view/133?title=blyudo_ot_komyuniti_shefa_aleny_mischenko_spagetti_karbonara">
                        <img src="/upload/dishimage/5d/52453e50df14c2d041f6863fcf461a92.jpg" width="275" alt="Блюдо от комьюнити-шефа Алены Мищенко. Спагетти Карбонара">
                        <span class="mask">&nbsp;</span>
                    </a>
                    <a data-cat="13" rel="2" href="/cart/add/133/?q=2" class="to-cart callbuy-popup"></a>
                    <a href="/product/view/133?title=blyudo_ot_komyuniti_shefa_aleny_mischenko_spagetti_karbonara" class="play"></a>
                </div>
                <div class="info-row">
                    <span class="bottom-deco">&nbsp;</span>
                    <div class="info-frame">
                        <div class="title">
                            <a href="/product/view/133?title=blyudo_ot_komyuniti_shefa_aleny_mischenko_spagetti_karbonara">
                                Блюдо от комьюнити-шефа Алены Мищенко...								</a>
                        </div>
                        <span class="price"><strong>59.00</strong> грн.</span>
                        <span class="weight-text"><strong>250</strong> грамм</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div><!--main end-->
<div class="see-menu btn-holder center">
    <a href="/#top" class="green-btn">
        <span><?=Yii::t('frontend', 'Actualdish');?></span>
    </a>
</div>