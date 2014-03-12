<?php
/**
 * This is the model class for table "{{blog_dish}}".
 *
 * The followings are the available columns in table '{{blog_dish}}':
 * @property integer $id
 * @property integer $blog_id
 * @property integer $dish_id
 *
 * @method BlogDish active
 * @method BlogDish cache($duration = null, $dependency = null, $queryCount = 1)
 * @method BlogDish indexed($column = 'id')
 * @method BlogDish language($lang = null)
 * @method BlogDish select($columns = '*')
 * @method BlogDish limit($limit, $offset = 0)
 * @method BlogDish sort($columns = '')
 *
 * The followings are the available model relations:
 * @property Dish $dish
 * @property Blog $blog
 */
class BlogDish extends BaseActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
     * @return BlogDish the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{blog_dish}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('blog_id, dish_id', 'required'),
            array('blog_id, dish_id', 'numerical', 'integerOnly' => true),
            array('blog_id', 'exist', 'className' => 'Blog', 'attributeName' => 'id'),
            array('dish_id', 'exist', 'className' => 'Dish', 'attributeName' => 'id'),
        
            array('id, blog_id, dish_id', 'safe', 'on' => 'search'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'dish' => array(self::BELONGS_TO, 'Dish', 'dish_id'),
            'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'blog_id' => Yii::t('backend', 'Blog'),
            'dish_id' => Yii::t('backend', 'Dish'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.blog_id',$this->blog_id);
		$criteria->compare('t.dish_id',$this->dish_id);

		$criteria->with = array('dish', 'blog');

        return parent::searchInit($criteria);
    }
    public function updateForDish($id, $newData = array())
    {
        $buff = array();
        // rid of possibly duplicated size values, use last one

        foreach($newData as $item)
            if((int)$item['dish_id']>0)
                $buff[(int)$item['dish_id']] = $item['dish_id'];
        $newData = $buff;

        if(empty($newData))
            return self::model()->deleteAllByAttributes(array('blog_id' => $id));



        $o = 0;
        $delete = array();

        // update existing product info with new quantities, prices
        /** @var $curData ProductInfo[] */
        $curData = self::model()->findAllByAttributes(array('blog_id' => $id));
        foreach($curData as $item)
        {
            if(!isset($newData[$item['dish_id']]))
            {
                $delete[] = $item['dish_id'];
                continue;
            }

            /*
            if((int)$newData[$item['size']]['quantity'] === (int)$item->quantity && (int)$newData[$item['size']]['price'] === (int)$item->price)
                        {
                            unset($newData[$item['size']]);
                            continue;
                        }*/

            if((int)$newData[$item['dish_id']]>0){
                //$item->value = (int)$newData[$item['dish_id']];
                //$item->update(array('value', ));
                unset($newData[$item['dish_id']]);
                ++$o;
            }
        }

        // delete info
        self::model()->deleteAllByAttributes(array('blog_id' => $id, 'dish_id' => $delete));

        // add new info
        $model = new self();
        foreach($newData as $dish_id => $value)
        {
            $model->blog_id = $id;
            $model->dish_id = $dish_id;
            if($model->save(false))
            {
                ++$o;
                $model->id = null;
                $model->setIsNewRecord(true);
            }
        }

        return $o;
    }
}