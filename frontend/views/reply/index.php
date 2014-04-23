   		<div id="main"><!--main start-->
	         <? if(isset($replies)){?>
                <div class="replies">
                    <div class="replies-header">
                    </div>
                    <ul class="reply-list">
                        <?
                        $cnt=1;
                        foreach($replies as $reply){
                        ?>
                        <li<?=($cnt==4)?' class="reply-last"':'';?>>
                            <div class="reply-image"><?=$reply->image->asHtmlImage($reply->login);?></div>
                            <div class="reply-desc"><span class="replier">@<?=$reply->login;?></span><span class="reply-test"><?=$reply->detail_text;?></span></div>
                        </li>
                        <?
                            $cnt++;
                            if($cnt==5)
                                $cnt=1;
                        }?>
                    </ul>
                </div>
                <?}?>
    	</div><!--main end-->