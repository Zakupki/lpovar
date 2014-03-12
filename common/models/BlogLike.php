<?php
/**
 * This is the model class for table "{{blog_view}}".
 *
 * The followings are the available columns in table '{{blog_view}}':
 * @property integer $id
 * @property integer $blog_id
 * @property integer $user_id
 *
 * @method BlogView active
 * @method BlogView cache($duration = null, $dependency = null, $queryCount = 1)
 * @method BlogView indexed($column = 'id')
 * @method BlogView language($lang = null)
 * @method BlogView select($columns = '*')
 * @method BlogView limit($limit, $offset = 0)
 * @method BlogView sort($columns = '')
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Blog $blog
 */
class BlogLike extends BaseActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
     * @return BlogView the static model class
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
        return '{{blog_like}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('blog_id, user_id', 'required'),
            array('blog_id, user_id', 'numerical', 'integerOnly' => true),
            array('blog_id', 'exist', 'className' => 'Blog', 'attributeName' => 'id'),
            array('user_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
        
            array('id, blog_id, user_id', 'safe', 'on' => 'search'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
            'user_id' => Yii::t('backend', 'User'),
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
		$criteria->compare('t.user_id',$this->user_id);

		$criteria->with = array('user', 'blog');

        return parent::searchInit($criteria);
    }
}