<?php
/**
 * This is the model class for table "{{category_child}}".
 *
 * The followings are the available columns in table '{{category_child}}':
 * @property integer $parent_pid
 * @property integer $child_pid
 *
 * The followings are the available model relations:
 * @property Category $prent
 * @property Category $child
 */
class CategoryChild extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
     * @return CategoryChild the static model class
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
        return '{{category_child}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('parent_pid, child_pid', 'required'),
            array('parent_pid, child_pid', 'numerical', 'integerOnly' => true),

            array('parent_pid, child_pid', 'safe', 'on' => 'search'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'Category', 'parent_pid'),
            'child' => array(self::BELONGS_TO, 'Category', 'child_pid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'parent_pid' => Yii::t('cp', 'Parent'),
            'child_pid' => Yii::t('cp', 'Child'),
        );
    }
}