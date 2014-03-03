<?if (isset($printable) && $printable){?>
<html>
<?}else{
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$course->recipeimage->file);
    header("Pragma: no-cache");
    header("Expires: 0");
}
echo $course->recipeimage->asHtmlImage($course->title);
if(isset($printable) && $printable){?>
<script>window.print();</script>
</html>
<?}?>
