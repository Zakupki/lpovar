<?php

class BlogController extends FrontController
{
	public function actionIndex()
	{
        $items=Blog::model()->sort()->active()->findAll();
		$this->render('index',array('items'=>$items));
	}
	
	
	public function actionView($id=null) {
		//$managers=User::model()->with(array('userUsertypes'=>array('joinType'=>'inner join')))->findAll('userUsertypes.id=3');
        $item=Blog::model()->active()->findByPk($id);
		
		if($seo=Seo::model()->find('t.pid=:id AND t.entity="'.$this->id.'"', array(':id'=>$item->id)))
		{
			$this->seo_title=$seo->title;
			$this->seo_description=$seo->description;
			$this->seo_keywords=$seo->keywords;
		}
		
		$this->render('view', array('item'=>$item));
	}
}