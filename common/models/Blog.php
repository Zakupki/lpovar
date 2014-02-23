<?php
/**
 * This is the model class for table "{{blog}}".
 *
 * The followings are the available columns in table '{{blog}}':
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property integer $image_id
 * @property string $preview_text
 * @property string $detail_text
 * @property string $date_create
 * @property integer $views
 * @property integer $likes
 * @property integer $comments
 * @property integer $sort
 * @property integer $status
 *
 * @method Blog active
 * @method Blog cache($duration = null, $dependency = null, $queryCount = 1)
 * @method Blog indexed($column = 'id')
 * @method Blog language($lang = null)
 * @method Blog select($columns = '*')
 * @method Blog limit($limit, $offset = 0)
 * @method Blog sort($columns = '')
 *
 * The followings are the available model relations:
 * @property User $user
 * @property File $image
 */
class Blog extends BaseActiveRecord
{

    public function behaviors()
    {
        return array(
            'attach' => array(
                'class' => 'common.components.FileAttachBehavior',
                'imageAttributes' => array(
                    'image_id',
                ),
                'fileAttributes' => array(
                ),
            )
        );
    }

    /**
     * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
     * @return Blog the static model class
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
        return '{{blog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('user_id, date_create', 'required'),
            array('user_id, views, likes, comments, sort, status', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('image_id, preview_text, detail_text', 'safe'),
            array('image_id', 'file', 'types' => File::getAllowedExtensions(), 'allowEmpty' => true, 'on' => 'upload'),
            array('user_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
        
            array('id, title, user_id, image_id, preview_text, detail_text, date_create, views, likes, comments, sort, status', 'safe', 'on' => 'search'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'image' => array(self::BELONGS_TO, 'File', 'image_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => Yii::t('backend', 'Title'),
            'user_id' => Yii::t('backend', 'User'),
            'image_id' => Yii::t('backend', 'Image'),
            'preview_text' => Yii::t('backend', 'Preview Text'),
            'detail_text' => Yii::t('backend', 'Detail Text'),
            'date_create' => Yii::t('backend', 'Date Create'),
            'views' => Yii::t('backend', 'Views'),
            'likes' => Yii::t('backend', 'Likes'),
            'comments' => Yii::t('backend', 'Comments'),
            'sort' => Yii::t('backend', 'Sort'),
            'status' => Yii::t('backend', 'Status'),
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
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.image_id',$this->image_id);
		$criteria->compare('t.preview_text',$this->preview_text,true);
		$criteria->compare('t.detail_text',$this->detail_text,true);
		$criteria->compare('t.date_create',$this->date_create,true);
		$criteria->compare('t.views',$this->views);
		$criteria->compare('t.likes',$this->likes);
		$criteria->compare('t.comments',$this->comments);
		$criteria->compare('t.sort',$this->sort);
		$criteria->compare('t.status',$this->status);

		$criteria->with = array('user');

        return parent::searchInit($criteria);
    }
}