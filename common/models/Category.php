<?php
/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property integer $pid
 * @property string $language_id
 * @property string $title
 * @property string $apparel
 * @property integer $sort
 * @property integer $status
 *
 * @method Category active
 * @method Category cache($duration = null, $dependency = null, $queryCount = 1)
 * @method Category indexed($column = 'language_id')
 * @method Category language($lang = null)
 * @method Category select($columns = '*')
 * @method Category limit($limit, $offset = 0)
 * @method Category sort($columns = '')
 *
 * The followings are the available model relations:
 * @property Language $language
 * @property Category[] $children
 * @property Category[] $parents
 */
class Category extends LangActiveRecord
{
    /**
     * Category parents strings
     *
     * @var array
     */
    private static $parentsStr = null;

    /**
     * Fetch category tree
     *
     * @return array
     */
    public function fetchTree()
    {
        if(($o = getCache('categoryTree_'.app()->language)))
            return $o;

        $data = app()->db->createCommand()
            ->select(array(
                'c.pid',
                'c.title',
                'GROUP_CONCAT(p.title SEPARATOR "\n") AS parents',
            ))
            ->from('{{category}} c')
            ->leftJoin('{{category_child}} cc', 'cc.child_pid = c.pid')
            ->leftJoin('{{category}} p', 'p.language_id = c.language_id AND p.pid = cc.parent_pid')
            ->where('c.status = 1 AND c.language_id = :lang AND cc.parent_pid IS NOT NULL')
            ->group('c.pid')
            ->order('c.sort')
            ->queryAll(true, array(':lang' => app()->language));

        $o = array();
        foreach($data as $item)
        {
            $parents = explode("\n", $item['parents']);
            foreach((array)$parents as $parent)
            {
                $o[$parent][$item['pid']] = $item['title'];
            }
        }

        setCache('categoryTree_'.app()->language, $o, param('cacheDuration'), new TagCacheDependency('Category'));

        return $o;
    }

    /**
     * Get apparel label
     *
     * @param string $apparel Apparel code [cloth, shoe]
     * @return string
     */
    public function getApparelLabel($apparel)
    {
        $apparels = $this->getApparels();
        if(isset($apparels[$apparel]))
            return $apparels[$apparel];

        return $apparel;
    }

    /**
     * Return genders list
     *
     * @return array
     */
    public function getApparels()
    {
        return array(
            'cloth' => Yii::t('common', 'Cloth'),
            'shoe' => Yii::t('common', 'Shoe'),
        );
    }

    /**
     * Get grouped category parents
     *
     * @return string
     */
    public function getParentsStr()
    {
        if(!self::$parentsStr)
        {
            $sql = app()->db->createCommand()
                ->select(array(
                    'cc.child_pid',
                    'GROUP_CONCAT(p.title SEPARATOR ", ") AS parents',
                ))
                ->from('{{category_child}} cc')
                ->leftJoin('{{category}} p', 'p.language_id = :lang AND p.pid = cc.parent_pid')
                ->group('cc.child_pid');

            $o = array();
            foreach($sql->queryAll(true, array(':lang' => app()->language)) as $item)
                $o[$item['child_pid']] = $item['parents'];

            self::$parentsStr = $o;
        }

        return (isset(self::$parentsStr[$this->pid]) ? self::$parentsStr[$this->pid] : null);
    }

    /**
     * Fetch parent categories
     *
     * @return array
     */
    public function fetchParents()
    {
        $sql = app()->db->createCommand()
            ->select('pid, title')
            ->from('{{category}}')
            ->where('language_id = :lang AND pid NOT IN (SELECT child_pid FROM {{category_child}})');

        return $sql->queryAll(true, array(':lang' => app()->language));
    }

    public function fixedAttributes()
    {
        return CMap::mergeArray(parent::fixedAttributes(), array(
            'apparel',
        ));
    }

    public function behaviors()
    {
        return array(
            'junction' => array(
                'class' => 'common.components.JunctionBehavior',
                'relations' => array(
                    'parents' => array(
                        'table' => '{{category_child}}',
                        'idColumn' => 'pid',
                        'primaryColumn' => 'parent_pid',
                        'secondaryColumn' => 'child_pid',
                    )
                )
            )
        );
    }

    /**
     * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
     * @return Category the static model class
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
        return '{{category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('title', 'required'),
            array('sort, status', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 256),
            array('apparel', 'in', 'range' => array('cloth', 'shoe')),

            array('id, pid, language_id, title, apparel, sort, status', 'safe', 'on' => 'search'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
            'products' => array(self::HAS_MANY, 'Product', array('language_id' => 'language_id', 'category_pid' => 'pid')),

            'childParents' => array(self::HAS_MANY, 'CategoryChild', 'child_pid', 'joinType' => 'INNER JOIN'),
            'parents' => array(self::HAS_MANY, 'Category', array('parent_pid' => 'pid'),
                'through' => 'childParents',
                'joinType' => 'INNER JOIN',
                'scopes' => array('language')
            ),

            'parentChildren' => array(self::HAS_MANY, 'CategoryChild', 'parent_pid', 'joinType' => 'INNER JOIN'),
            'children' => array(self::HAS_MANY, 'Category', array('child_pid' => 'pid'),
                'through' => 'parentChildren',
                'joinType' => 'INNER JOIN',
                'scopes' => array('language')
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'pid' => 'PID',
            'language_id' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'apparel' => Yii::t('backend', 'Apparel'),
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
		$criteria->compare('t.pid',$this->pid);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.apparel',$this->apparel,true);
		$criteria->compare('t.sort',$this->sort);
		$criteria->compare('t.status',$this->status);

        return parent::searchInit($criteria);
    }
}