<html>
<style>
.body{

}
</style>
<div class="body">
<h2>Рецепт: <?=$course->title;?></h2>
    <p>
        <? if(isset($course->image)){
            echo $course->image->asHtmlImage($course->title);
        }?>
    </p>
    <p>
        <?=$course->detail_text;?>
    </p>
    <h3>Ингредиенты:</h3>
    <table class="details-table" cellspacing="0" cellpadding="5" border="0">
        <? foreach($course->courseIngredients as $ingredient){?>
        <tr>
            <td><?=$ingredient->ingredient->title;?></td>
            <td><?=$ingredient->value;?></td>
        </tr>
        <?}?>
    </table>
</div>
</html>
