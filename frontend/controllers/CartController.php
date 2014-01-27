<?php
class CartController extends FrontController
{
	public $totalCart;
	public $_identity;
    public function init()
    {
    	parent::init();
        Yii::import('common.extensions.shopping-cart.*');
		Yii::import('common.extensions.yii-mail.*');
    }
	
	public function actionSuccess(){
		//CVarDumper::dump($_POST);	
		parent::actionMessage('Оплата','Вы успешно прощли процедуру оплаты. Менеджер свяжется с вами после получения оплаты.');
	}
	public function actionCheck(){
		//CVarDumper::dump($_POST);	
		parent::actionMessage('Оплата','Ваш платеж проходит проверку. Менеджер свяжется с вами после получения оплаты.');
	}
	
	public function actionInterstatus(){
		$data=json_encode($_POST);
		$test=new Test();
		$test->text=$data;
		$test->save();
		$new=false;

        $test2=Interkassa::model()->findByPk($_POST['ik_payment_id']);
		if($test2->ik_payment_id<1)
		$test2=new Interkassa;

        $test2->attributes=$_POST;
		$test2->save();
		
			if($test2->ik_payment_id>0){

                $order=Order::model()->with('user')->findByPk($test2->ik_payment_id);

                if($order->orderstate_id!=5 && $order->orderstate_id!=6){

                    if($test2->ik_payment_state=='success')
                        $order->orderstate_id=5;
                    elseif($test2->ik_payment_state=='fail')
                        $order->orderstate_id=6;
                    $order->save();
                    if($order->id>0 && $order->orderstate_id==5){
                        $message = new YiiMailMessage;
                        $message_body='
                        Здравствуйте!<br><br>
                        Ваш заказ №'.$order->id.' успешно оплачен через систему интеркасса<br><br>
                        В течение 10 минут наш менеджер вам перезвонит.<br><br>
                        Наш телефон: '.Option::getOpt('mainphone').'<br><br>
                        С уважением,<br>
                        Личный Повар';
                        $message->setBody($message_body, 'text/html');
                        $message->subject = 'Заказ оплачен';
                        $message->addTo($order->user->email);
                        $message->from = Yii::app()->params['adminEmail'];
                        Yii::app()->mail->send($message);

                        $message = new YiiMailMessage;
                        $message_body='
                        Заказ №'.$order->id.' от пользователя '.$order->user->email.' на сумму '.$order->ik_payment_amount.' успешно оплачен через систему интеркасса.';
                        $message->setBody($message_body, 'text/html');
                        $message->subject = 'Новая оплата заказа';
                        $orderuserarr=explode(',',Option::getOpt('order_emails'));
                        foreach($orderuserarr as $order_u)
                        $message->addTo(trim($order_u));
                        $message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
                        Yii::app()->mail->send($message);
                    }
			    }
            }
	}
	
	public function actionTest()
    {
	$message = new YiiMailMessage;
	$message->setBody('Message content here with HTML', 'text/html');
	$message->subject = 'My Subject';
	$message->addTo('dmitriy.bozhok@gmail.com');
	$message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
	Yii::app()->mail->send($message);
	}
		
	public function actionIndex()
    {
    	$session=new CHttpSession;
  	   	$session->open();
		$userdiscount=null;
        $discount=null;
        if(yii::app()->user->getId()){
            $userdata=yii::app()->user->getData();
			if($userdata['discount']){
			$userdiscount=$discount=$userdata['discount'];
            }
		}elseif(yii::app()->user->getId()<1 && $session['discemail']){
			$userdata=User::model()->find('t.email=:email',array(':email'=>$session['discemail']));
			if(isset($userdata->discount))
			$userdiscount=$discount=$userdata['discount'];
            elseif($session['discount'])
            $discount=$session['discount'];
		}else
			$discount=$session['discount'];
        echo $discount;
        $orders=$this->cart->getPositions();
        $notin=null;
        //if(!$discount && !$userdiscount)
        $discount=$session['discount'];
        //echo $discount;
        if(count($orders)>0)
        $notin=' AND t.similar_id NOT IN('.implode(',',array_keys($orders)).') AND t.dish_id IN('.implode(',',array_keys($orders)).')';
        
        //$topdishes=Dish::model()->with(array('portions','dishtype'=>array('with'=>'dishtypeimage')))->findAll('t.id>0'.$notin);
		$topdishes=DishSimilar::model()->with(array('similar'=>array('with'=>array('portions','dishImages'))))->limit(5,0)->findAll('t.dish_id>0'.$notin);
		
		$paytype=Paytype::model()->sort()->active()->findAll('t.status=1');
		$this->render('index',array('orders'=>$orders,'totalCost'=>$this->cart->getCost(), 'paytype'=>$paytype, 'topdishes'=>$topdishes,
		'delivery_name'=>$session['delivery_name'],'email'=>$session['discemail'], 'phone'=>$session['delivery_phone'], 
		'delivery_from'=>$session['delivery_from'], 'delivery_till'=>$session['delivery_till'], 'delivery_addr'=>$session['delivery_addr'],
		'discount'=>$discount, 'userdiscount'=>$userdiscount
		));
	}
	public function actionAdddrink()
    {
    	if(!$orderDrink = OrderDrink::model()->findByAttributes(array(
            'order_id' => $_POST['order_id'], 'drink_id'=>$_POST['drink_id']
        ))){
			$orderDrink=new OrderDrink;
		}else{
			$_POST['quantity']=$_POST['quantity']+$orderDrink->quantity;
		}
		$orderDrink->attributes=$_POST;
		$orderDrink->save();
		if($orderDrink->id>0){
			$table=null;
			
			#Пересчет заказа
			$newfoodPrice=null;
			$newPrice=null;
			$cnt=1;
			$order=Order::model()->with(array('orderDishes'=>array('with'=>'dish'),'user','orderDrinks'=>array('with'=>'order')))->find('t.id=:id',array(':id'=>$orderDrink->order_id));
			foreach($order->orderDishes as $orderedDish){
				$newfoodPrice=$newfoodPrice+($orderedDish->dish->price*$orderedDish->quantity);
				$table.='<tr><td>'.$cnt.'</td><td>'.$orderedDish->dish->title.'</td><td>'.$orderedDish->quantity.'</td><td>'.$orderedDish->dish->price.'</td><td>'.$orderedDish->dish->price*$orderedDish->quantity.' грн</td></tr>';
				$cnt++;
			}
            $charities=CharityOrder::model()->findByPk($order->id);
            foreach($charities as $charOrder){
                $table.='<tr><td></td><td>'.$charOrder->charity->title.'</td><td></td><td></td><td>'.$charOrder->charity->value.' грн</td></tr>';
                $newfoodPrice=$newfoodPrice+$charOrder->charity->value;
            }

			$disc_percent=null;
			if($order->discount_id>0){
			    $discount=Discount::model()->findByPk($order->discount_id);
				$discountfoodPrice=$newfoodPrice/100*(100-$discount->discount);
                $disc_percent=$discount->discount;
			}elseif($order->user->discount){
                $discountfoodPrice=$newfoodPrice/100*(100-$order->user->discount);
                $disc_percent=$order->user->discount;
            }
            else
			$discountfoodPrice=$newfoodPrice;
			
            
            
			foreach($order->orderDrinks as $orderedDrink){
				$newPrice=$newPrice+($orderedDrink->drink->price*$orderedDrink->quantity);
				$table.='<tr><td>'.$cnt.'</td><td>'.$orderedDrink->drink->title.'</td><td>'.$orderedDrink->quantity.'</td><td>'.$orderedDrink->drink->price.'</td><td>'.$orderedDrink->drink->price*$orderedDrink->quantity.' грн</td></tr>';
				$cnt++;
			}
			
			$nonDiscountPrice=$newPrice+$newfoodPrice;
			
			
			$newPrice=$newPrice+$discountfoodPrice;
            
            if($order->orderDishes || $order->orderDrinks){
            settype($newPrice,"double");
			$order->total=$newPrice;
			$order->save();
			}
			
			#Сообщение пользователю
			$message = new YiiMailMessage;
			$message_body='
			Здравствуйте!<br><br>
			После добавления вина ваш заказ №'.$_POST['order_id'].' обновился:<br><br>
			<table border="1">
			<tr><td>№</td><td>Название</td><td>Количество</td><td>Цена за шт.</td><td>Цена всего</td></tr>
			'.$table.'
			<tr><td colspan="3"></td><td>Всего:</td><td>'.$nonDiscountPrice.' грн</td></tr>';
			if($disc_percent>0){
				$message_body.='
				<tr><td colspan="3"></td><td>Скидка на наборы:</td><td>-'.$disc_percent.'%</td></tr>
				<tr><td colspan="3"></td><td>Всего со скидкой:</td><td>'.$newPrice.' грн</td></tr>
				';
			}
			
			$message_body.='</table><br>
			В течение 10 минут наш менеджер вам перезвонит.<br><br>
			Наш телефон: '.Option::getOpt('mainphone').'<br><br>
			С уважением,<br>
			Личный Повар';
			$message->setBody($message_body, 'text/html');
			$message->subject = 'Обновление заказа у Личного Повара';
			$message->addTo($order->user->email);
			$message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
			Yii::app()->mail->send($message);
			
			
			#Сообщение менеджерам
			$message = new YiiMailMessage;
			
			$managermessage='Здравствуйте!<br><br>
			Поступило обновление заказа №'.$order->id.' от пользователя '.$order->user->email.'. Новая сумма заказа '.$nonDiscountPrice.' грн.<br><br>
			<table border="1">
			<tr><td>№</td><td>Название</td><td>Количество</td><td>Цена за шт.</td><td>Цена всего</td></tr>
			'.$table.'
			<tr><td colspan="3"></td><td>Всего:</td><td>'.$nonDiscountPrice.' грн</td></tr>';
			if($disc_percent>0){
				$managermessage.='
				<tr><td colspan="3"></td><td>Скидка на наборы:</td><td>-'.$disc_percent.'%</td></tr>
				<tr><td colspan="3"></td><td>Всего со скидкой:</td><td>'.$newPrice.'</td></tr>
				';
			}
			$managermessage.='</table>
			<br><br>
            Данные заказчика:<br><br>
            Имя: '.$order->user->name.'<br>
            Телефон: '.$order->user->phone.'<br>
            Адрес доставки: '.$order->delivery_addr.'<br>
            Доставка c: '.$order->delivery_from.'<br>
            Доставка до: '.$order->delivery_till.'<br><br>
            Для просмотра заказа зайдите в панель упровления и просмотрите <a href="http://'.$_SERVER['HTTP_HOST'].'/backend.php?r=order/update&id='.$order->id.'">заказ</a>.
			';
			$message->setBody($managermessage,'text/html');
			$message->subject = 'Обновление заказа';
			$orderuserarr=explode(',',Option::getOpt('order_emails'));
			foreach($orderuserarr as $order_u)
			$message->addTo(trim($order_u));
			$message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
			Yii::app()->mail->send($message);
			
			#Ответ серверу	
			$this->sendJsonResponse(array(
	            'error' => false,
	            'status' => '',
	            'totalprice' =>$newPrice
	        ));	
		}
		die();
	}
	
	public function actionOrder()
    {
    	
		$cart = $this->getCart();
	  	$orders=$this->cart->getPositions();
		if(count($orders)<1)
		$this->redirect('/');		
     	if(yii::app()->user->getId()>0){
     		 $_POST['user_id']=yii::app()->user->getId();
			 $user = User::model()->findByPk(yii::app()->user->getId());
			 if($_POST['phone'])
			 $user->phone=$_POST['phone'];
			 if($_POST['delivery_addr'])
			 $user->delivery_addr=$_POST['delivery_addr'];
			 $user->save(array('phone','delivery_addr'));
			 $user_email=yii::app()->user->getEmail();
		}
		elseif($_POST['email']){
			$user = User::model()->findByAttributes(array(
            'email' => $_POST['email']
        	));
			if(isset($user)){
				$_POST['user_id']=$user->id;
				if($_POST['phone'])
				$user->phone=$_POST['phone'];
				if(isset($_POST['delivery_addr']))
				$user->delivery_addr=$_POST['delivery_addr'];
				$user->save();
			}
			else{
				$password=User::randomPassword();
				$user = new User;
				$user->email=$_POST['email'];
				$user->name=$_POST['name'];
				$user->phone=$_POST['phone'];
				$user->delivery_addr=$_POST['delivery_addr'];
				$user->display_name=$_POST['email'];
				$user->password=$password;
				$user->save();
				if($user->id>0){
					$user_email=$user->email;
					$_POST['user_id']=$user->id;
					$message = new YiiMailMessage;
					$message->setBody('
					Здравствуйте!<br><br>
					Вы были автоматически зарегистрированы на сайте '.$_SERVER['HTTP_HOST'].'.<br>
					Если вы хотите получить доступ к видеорецептам, пожалуйста, войдите на сайт. Данные для входа:<br>
					Ваш логин: '.$_POST['email'].'<br>
					Ваш пароль: '.$password.'<br>
					Вы всегда сможете изменить эти данные в <a href="http://lpovar.com.ua">личном кабинете</a> на сайте.<br><br>
					Наш телефон: '.Option::getOpt('mainphone').'<br>
					С уважением,<br>
					Личный Повар', 'text/html');
					$message->subject = 'Регистрация у Личного Повара';
					$message->addTo($_POST['email']);
					$message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
					Yii::app()->mail->send($message);
					
					$this->_identity=new UserIdentity($user->email,$password);
					$this->_identity->authenticate(true);
					if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
					{
						$duration = 3600*24*1;
						Yii::app()->user->login($this->_identity,$duration);
					}
					
					
						
				}
			}
		}
		
		$_POST['dete_create']='NOW()';
		$session=new CHttpSession;
  	   	$session->open();
		
		
		if($user->discount>0){
			$_POST['total']=$this->cart->getCost()/100*(100-$user->discount);
		}
		elseif($user->discount<1 && isset($session['discount_id'])){
			$_POST['discount_id']=$session['discount_id'];
			$_POST['total']=$this->cart->getCost()/100*(100-$session['discount']);
		}else
			$_POST['total']=$this->cart->getCost();
		
		//$_POST['orderstate_id']=1;
		$order = new Order();
		$order->attributes=$_POST;
		$order->save();
		$dishArr=array();
		if($order->id>0 && count($orders)>0){
		
			if($order->getErrors()){
			$this->redirect('/cart/');
			die();
			}
			
			$cnt=1;
			$table=null;
			foreach($orders as $dish){
				$orderdish=null;
		        $dishArr[$dish->id]=$dish->id;
				$orderdish = new OrderDish();
				$orderdish->quantity=$dish->quantity;
				$orderdish->order_id=$order->id;
				$orderdish->dish_id=$dish->id;
				$orderdish->save();
				if($orderdish->id>0)
				$table.='<tr><td>'.$cnt.'</td><td>'.$dish->title.'</td><td>'.$dish->quantity.'</td><td>'.$dish->price.'</td><td>'.$dish->price*$dish->quantity.' грн</td></tr>';
			$cnt++;	
			}
            $charitybody='';
            $charityCost='';
            if(isset($_POST['charity'])){
                foreach($_POST['charity'] as $charity){
                    $charityUser=new CharityOrder;
                    $charityUser->order_id=$order->id;
                    $charityUser->charity_id=$charity;
                    $charityUser->save();
                    $char=Charity::model()->findByPk($charity);
                    $charityCost=$charityCost+$char->value;
                    $charitybody.='<tr><td></td><td>'.$char->title.'</td><td></td><td></td><td>'.$char->value.' грн</td></tr>';
                }
            }

			$messageuserbody=null;
			if(isset($user->discount)){
			$messageuserbody='
			<tr><td colspan="3"></td><td>Скидка:</td><td>-'.$user->discount.'%</td></tr>
			<tr><td colspan="3"></td><td>Всего со скидкой:</td><td>'.$_POST['total'].' грн</td></tr>';	
			}
			elseif(isset($session['discount'])){
			$messageuserbody='
			<tr><td colspan="3"></td><td>Скидка:</td><td>-'.$session['discount'].'%</td></tr>
			<tr><td colspan="3"></td><td>Всего со скидкой:</td><td>'.$_POST['total'].' грн</td></tr>';	
			}
			
			#Сообщение покупателю
			$message = new YiiMailMessage;
			$message_body='
			Здравствуйте!<br><br>
			Спасибо, что сделали заказ на сайте Lpovar.com.ua.<br><br>
			Ваш заказ №'.$order->id.':<br><br>
			<table border="1">
			<tr><td>№</td><td>Название</td><td>Количество</td><td>Цена за шт.</td><td>Цена всего</td></tr>
			'.$table.'
			'.$charitybody.'
			<tr><td colspan="3"></td><td>Всего:</td><td>'.$this->cart->getCost()+$charityCost.' грн</td></tr>
			'.$messageuserbody.'
			</table><br><br>
			Ваши данные:<br><br>
			Имя: '.$user->name.'<br>
			Телефон: '.$user->phone.'<br>
			Адрес доставки: '.$user->delivery_addr.'<br>
			Доставка с: '.$user->delivery_from.'<br>
			Доставка до: '.$user->delivery_till.'<br><br>
			
			В течение 10 минут наш менеджер вам перезвонит.<br><br>
			Кстати, видео-рецепт вы можете найти на странице блюда, на нашем сайте ;)
			
			Наш телефон: '.Option::getOpt('mainphone').'<br><br>
			С уважением,<br>
			Личный Повар';
			$message->setBody($message_body, 'text/html');
			$message->subject = 'Личный Повар ваш заказ принял';
			$message->addTo($user->email);
			$message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
			Yii::app()->mail->send($message);
			
			#Скидочная программа пользователя
			/*
			$userorders=count(Order::model()->findAll('t.user_id='.$_POST['user_id']));
						if($userorders==1){
							$discount=new Discount;
							$discount->title="РђРІС‚РѕРјР°С‚РёС‡РµСЃРєР°СЏ СЃРєРёРґРєР° РґР»СЏ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏ ".$_POST['user_id']."";
							$discount->user_id=$_POST['user_id'];
							$discount->discount=10;
							$discount->discounttype_id=1;
							$discount->discountmode_id=2;
							$discount->activations=1;
							$discount->disccode=$this->genRandomString();
							$discount->save();
							
							$message = new YiiMailMessage;
							$message_body='
							Р—РґСЂР°РІСЃС‚РІСѓР№С‚Рµ!<br><br>
							РЎРїР°СЃРёР±Рѕ, С‡С‚Рѕ СЃРґРµР»Р°Р»Рё СЃРІРѕР№ РїРµСЂРІС‹Р№ Р·Р°РєР°Р· РЅР° СЃР°Р№С‚Рµ Lpovar.com.ua.<br><br>
							РџСЂРµРґР»РѕР¶РёС‚Рµ Р·РЅР°РєРѕРјРѕРјСѓ РїРѕР»СЊР·РѕРІР°С‚РµР»СЋ СЃРґРµР»Р°С‚СЊ РїРѕРєСѓРїРєСѓ РЅР° РЅР°С€РµРј СЃР°Р№С‚Рµ СЃ РїРѕРјРѕС‰СЊСЋ РІР°С€РµРіРѕ РїРµСЂСЃРѕРЅР°Р»СЊРЅРѕРіРѕ СЃРєРёРґРѕС‡РЅРѕРіРѕ РєРѕРґР° Рё РїРѕР»СѓС‡РёС‚Рµ Р±РѕРЅСѓСЃ!<br><br>
							Р’Р°С€ СЃРєРёРґРѕС‡РЅС‹Р№ РєРѕРґ: '.$discount->disccode.'<br><br>
							РЎ СѓРІР°Р¶РµРЅРёРµРј,<br>
							Р›РёС‡РЅС‹Р№ РџРѕРІР°СЂ';
							$message->setBody($message_body, 'text/html');
							$message->subject = 'РџСЂРёРІРµРґРё РґСЂСѓРіР° Рє Р›РёС‡РЅРѕРјСѓ РџРѕРІР°СЂСѓ';
							$message->addTo($user->email);
							$message->from = array(Yii::app()->params['adminEmail']=>'Р›РёС‡РЅС‹Р№ РџРѕРІР°СЂ');
							Yii::app()->mail->send($message);
						}*/
			
			
			
			
			#Сообщение менеджерам
			$message = new YiiMailMessage;
			$messagebody=null;
			$messagebody='Здравствуйте!<br><br>
			Поступил новый заказ №'.$order->id.' от пользователя '.$user->email.' на сумму '.$this->cart->getCost().' грн.<br><br>
			<table border="1">
			<tr><td>№</td><td>Название</td><td>Количество</td><td>Цена за шт.</td><td>Цена всего</td></tr>
			'.$table.'
			'.$charitybody.'
			<tr><td colspan="3"></td><td>Всего:</td><td>'.$this->cart->getCost()+$charityCost.' грн</td></tr>';
			if(isset($user->discount)){
			$messagebody.='
			<tr><td colspan="3"></td><td>Скидка:</td><td>-'.$user->discount.'%</td></tr>
			<tr><td colspan="3"></td><td>Всего со скидкой:</td><td>'.$_POST['total']+$charityCost.' грн</td></tr>';
			}
			elseif(isset($session['discount'])){
			$messagebody.='<tr><td colspan="3"></td><td>Скидка:</td><td>-'.$session['discount'].'%</td></tr>';
			$messagebody.='<tr><td colspan="3"></td><td>Всего со скидкой:</td><td>'.$_POST['total']+$charityCost.' грн</td></tr>';
			}
			$messagebody.='</table><br><br>
			Данные заказчика:<br><br>
			Имя: '.$user->name.'<br>
			Телефон: '.$user->phone.'<br>
			Адрес доставки: '.$user->delivery_addr.'<br>
			Доставка c: '.$order->delivery_from.'<br>
			Доставка до: '.$order->delivery_till.'<br><br>
			Для просмотра заказа зайдите в панель упровления и просмотрите <a href="http://'.$_SERVER['HTTP_HOST'].'/backend.php?r=order/update&id='.$order->id.'">заказ</a>.
			';
			$message->setBody($messagebody, 'text/html');
			$message->subject = 'Новый заказ';
			$orderuserarr=explode(',',Option::getOpt('order_emails'));
			foreach($orderuserarr as $order_u)
			$message->addTo(trim($order_u));
			$message->from = array(Yii::app()->params['adminEmail']=>'Личный Повар');
			Yii::app()->mail->send($message);
			
		}
		$drinks=null;
		if(count($dishArr)>0)
            $drinks=DrinkDish::model()->getDrinks(array('dishes'=>$dishArr));
		//$drinks=DrinkDish::model()->with(array('drink'=>array('with'=>'image')),'active')->findAll('t.dish_id in('.implode(',',$dishArr).') AND drink.status=1');

		if($order->id>0)
		$cart->clear();
		
		unset($session['discount_id']);
		unset($session['discount']);
		unset($session['disccode']);
		unset($session['discemail']);
		
		$this->render('order',array('total'=>$order->total, 'order_id'=>$order->id,'drinks'=>$drinks, 'user_id'=>$_POST['user_id'], 'paytype_id'=>$_POST['paytype_id']));
	}

    public function filters()
    {
  	}

    public function actionAdd()
    {
    		
        $cart = $this->getCart();
		$dishForm = new DishForm();
		$dishForm->attributes = $_GET;
		if(!$dishForm->validate())
       	   {
        	   $errors = current($dishForm->getErrors());
		   }
        if(isset($_REQUEST['q']))
        	$this->cart->put($dishForm->fetchdish(),intval($_REQUEST['q']));
        else
            $this->cart->put($dishForm->fetchdish());

        $this->redirect('/cart/');
	}
	public function actionTest2()
    {
       $session=new CHttpSession;
  	   $session->open();
	   echo $session['disccode'];
	   echo "<br>";
	   echo $session['discemail'];
	   echo "<br>";
	   echo $session['discount'];
	   echo "<br>";
	   echo $session['discount_id'];
	   exit();
    }
	public function actionAdddiscount()
    {
       $session=new CHttpSession;
  	   $session->open();	
	   if(isset($_POST['code']))
       	$session['disccode']=$_POST['code'];
       if(isset($_POST['email'])){
		$userdata= User::model()->findByAttributes(array(
            'email' => $_POST['email']
        	));
			if(isset($userdata->discount)){
				if($userdata->discount>0){	
					$percents=$userdata->discount;
					unset($session['disccode']);
				}
			}
		$session['discemail']=$_POST['email'];
	   }
	   
	  
	   
	   if(isset($session['disccode']) && isset($session['discemail']) || isset($session['disccode']) || isset($session['disccode']) && Yii::app()->user->getId()>0){
        if(Yii::app()->user->getId()>0)
			$user=User::model()->findByPk(Yii::app()->user->getId());
		else	
	   		$user=User::model()->find('t.email=:email',array(':email'=>$session['discemail']));

           $discount=Discount::model()->find('t.disccode=:disccode',array(':disccode'=>$session['disccode']));
		if(isset($discount))
		if($discount->discounttype_id==1){
			if($discount->activations>0){
				if($user){
					$order=Order::model()->findAll('t.discount_id=:discount_id AND t.user_id=:user_id',array(':discount_id'=>$discount->id, ':user_id'=>$user->id));
					if($discount->activations>count($order) && $discount->discounttype_id=1){
						$percents=$discount->discount;
					}
				}else
					$percents=$discount->discount;
			}else
			$percents=$discount->discount;
		}
		elseif($discount->discounttype_id==2){
			if($user){
				$order=Order::model()->findAll('t.discount_id=:discount_id AND t.user_id=:user_id',array(':discount_id'=>$discount->id, ':user_id'=>$user->id));
					if($discount->activations>count($order)){
						$percents=$discount->discount;
					}
			}else
				$percents=$discount->discount;
        }
        elseif($discount->discounttype_id==3){
            $percents=$discount->discount;
        }

		}
	   if(isset($percents)){
	   if(isset($discount->id)){
		   $session['discount_id']=$discount->id;
		   $session['discount']=$percents;
		   }
       $this->sendJsonResponse(array(
          'error' => false,
          'id' => $discount->id,
          'discount' => $percents,
          'title' => $discount->title,
          'discounttype_id' => $discount->discounttype_id
       ));	
	   }
	   die();
	   
       //print_r($_POST);
	}
	
	public function actionDelete($id)
    {
    	$cart = $this->getCart();
		$cart->remove($id);
		$this->redirect('/cart/');
	}
	public function actionUpdatesingle()
    {
    	$remove=false;	
    	foreach($this->cart->getPositions() as $key => $item)
          {
          	 if($item->id==$_POST['item'] && $_POST['quantity']<1){
				$this->cart->remove($key);
				$remove=true;
			 }
			 elseif($item->id==$_POST['item'])
			 $this->cart->update($item, $_POST['quantity']);
		  }
		
    	$this->sendJsonResponse(array(
            'error' => false,
            'remove' => $remove,
            'totalcost'=>$this->cart->getCost()
        ));	
		die();
			
    	//$this->cart->update($item, $products[$key]);
	}
    public function actionUpdate()
    {
        $cart = $this->getCart();
        if(!isset($_POST['Product']))
        {
            $this->cart->clear();
        }
        else
        {
            $postData = $_POST['Product'];

            $products = array();
            foreach($postData as $data)
            {
                $itemKey = $data['id'].':'.$data['info'];
                if(!isset($products[$itemKey]))
                    $products[$itemKey] = 1;
                else
                    ++$products[$itemKey];
            }

            foreach($this->cart->getPositions() as $key => $item)
            {
                /** @var $item IECartPosition|ECartPositionBehaviour */
                if(!isset($products[$key]))
                {
                    $this->cart->remove($key);
                    continue;
                }

                if($item->getQuantity() != $products[$key])
                {
                    $this->cart->update($item, $products[$key]);
                    continue;
                }
            }
        }

        $this->sendJsonResponse(array(
            'error' => false,
            'content' => $this->renderPartial('/catalog/inc/_cart_items', array('cart' => $cart), true),
        ));
    }
    public function actionAdddeliverdata(){
        if(isset($_POST['name'])){
            $session=new CHttpSession;
            $session->open();
            $session['delivery_name']=$_POST['name'];
        }	
        if(isset($_POST['phone'])){
        	//$_POST['phone']=preg_replace('/(\W*)/', '', $_POST['phone']);
            $session=new CHttpSession;
            $session->open();
            $session['delivery_phone']=$_POST['phone'];
        }
		if(isset($_POST['delivery_from'])){
            $session=new CHttpSession;
            $session->open();
            $session['delivery_from']=$_POST['delivery_from'];
        }
		if(isset($_POST['delivery_till'])){
            $session=new CHttpSession;
            $session->open();
            $session['delivery_till']=$_POST['delivery_till'];
        }
		if(isset($_POST['delivery_addr'])){
            $session=new CHttpSession;
            $session->open();
            $session['delivery_addr']=$_POST['delivery_addr'];
        }
    }
	public function actionCheckdesert(){
		$orders=$this->cart->getPositions(); 	
		foreach($orders as $pos){
			if($pos->dishtype_id!=10){
			$this->sendJsonResponse(array(
	            'error' => false,
	            'desert' => 2,
	        ));
			break;
			}
		}
		$this->sendJsonResponse(array(
            'error' => false,
            'desert' => 1,
        ));
		
	}
	/*
	public function actionClearphones(){
			$phones=User::model()->limit(200,800)->findAll();
			foreach($phones as $ph){
				$ph->phone=preg_replace('/(\W*)/', '', $ph->phone);
				$ph->save();
			}
		}*/
	
}
