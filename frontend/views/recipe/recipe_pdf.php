<?if (isset($printable) && $printable){?>
<html>
<?}else{

    $filedata=pathinfo($course->recipeimage->file);
    //print_r($filedata);
    switch ($filedata['extension']) {
        case "pdf": $ctype="application/pdf"; break;
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "docx": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpg"; break;
        default: $ctype="application/force-download";
    }

    header("Content-Disposition: attachment; filename=".$course->recipeimage->file);
    header("Content-Type: ".$ctype."");
    readfile($_SERVER['DOCUMENT_ROOT'].'/'.$course->recipeimage->path.'/'.$course->recipeimage->file);


    /*header("Content-Type: application/octet-stream");
    header('Content-Disposition: attachment; filename="test.JPG"');
    $file = file_get_contents('/'.$course->recipeimage->path.'/'.$course->recipeimage->file, true);
    echo $file;*/
}
//echo $course->recipeimage->asHtmlImage($course->title);
if(isset($course->recipeimage)){
    echo '<img src="/'.$course->recipeimage->path.'/'.$course->recipeimage->file.'" width="95%">';
}

if(isset($printable) && $printable){?>
<script>window.print();</script>
</html>
<?}?>
