<div class="blog-gallery-holder">
    <ul class="promo-gallery">

    </ul>
    <div class="switcher">
        <ul>

        </ul>
    </div>
</div>
<div id="blog"><!--main start-->
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
                                    <span class="blog-views informer">100</span>
                                    <span class="blog-likes informer">100</span>
                                    <span class="blog-comments informer">100</span>
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