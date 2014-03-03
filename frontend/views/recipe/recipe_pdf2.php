<?php if (isset($printable) && $printable): ?>
<html>
<?php endif; ?>
<style>
.body{

}
</style>
<div class="body">
<h1>Рецепт: <?=$course->title;?></h2>
    <p>
        <? if(isset($course->image)){
            echo $course->image->asHtmlImage($course->title);
        }?>
    </p>
    <p>
        <?=$course->detail_text;?>
    </p>
    <h2>Ингредиенты:</h3>
    <table class="details-table" cellspacing="0" cellpadding="5" border="0">
        <? foreach($course->courseIngredients as $ingredient){?>
        <tr>
            <td><?=$ingredient->ingredient->title;?></td>
            <td><?=$ingredient->value;?></td>
        </tr>
        <?}?>
    </table>
    <h2>Детальный рецепт приготовления:</h3>
    <? foreach($course->steplist as $step){?>
        <div>
            <h3>Шаг <?=$step['step'];?></h3>
            <p><?=$step['preview_text'];?></p>
            <? if(isset($step->image)){?>
            <p><?=$step->image->asHtmlImage();?></p>
            <?}?>
            <p><?=$step['detail_text'];?></p>
        </div>
    <?}?>
</div>
<?php if (isset($printable) && $printable): ?>
<script>window.print();</script>
</html>
<?php endif; ?>
