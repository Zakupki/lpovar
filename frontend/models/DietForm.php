<?php

class DietForm extends CFormModel
{
	public $email;
	public $title;
    public $detail_text;
	
	

	private $_identity;

	public function rules()
	{
		return array(
			// username and password are required
			array('email, title, detail_text', 'required'),
		);
	}

	public function save()
	{
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

        return true;
	}
}
