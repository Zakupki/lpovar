<?php

class BlogController extends FrontController
{
	public function actionIndex()
	{
        $items=Blog::model()->sort()->active()->findAll();
        $dishes=Dish::model()->with('dishtype')->findAll(array(
            "condition" => "t.status=1 AND dishtype.dpid is null",
            "order" => "rand()",
            "limit" => 3,
        )  );
		$this->render('index',array('items'=>$items,'dishes'=>$dishes));
	}
	
	
	public function actionView($id=null) {
		//$managers=User::model()->with(array('userUsertypes'=>array('joinType'=>'inner join')))->findAll('userUsertypes.id=3');
        $item=Blog::model()->with('blogDishes')->active()->findByPk($id);
        $item->views=$item->views+1;
        $item->save();
       /* $dishes=Dish::model()->with('dishtype')->findAll(array(
            "condition" => "t.status=1 AND dishtype.dpid is null",
            "order" => "rand()",
            "limit" => 3,
            "together" => true
        )  );*/
		if($seo=Seo::model()->find('t.pid=:id AND t.entity="'.$this->id.'"', array(':id'=>$item->id)))
		{
			$this->seo_title=$seo->title;
			$this->seo_description=$seo->description;
			$this->seo_keywords=$seo->keywords;
		}
		
		$this->render('view', array('item'=>$item));
	}
    public function actionLike() {
        if(isset($_GET['id'])){
            $blog=Blog::model()->findByPk($_GET['id']);
            $blog->likes=$blog->likes+1;
            $blog->save();
            echo $blog->likes;
        }
    }
}