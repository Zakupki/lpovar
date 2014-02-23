<?php
/** @var $this BlogController */
/** @var $model Blog */
/** @var $form CActiveForm */
?>
<?php
$this->pageTitle = Yii::t('backend', 'Manage');
$this->breadcrumbs = array(
	Yii::t('backend', 'Blogs') => array('admin'),
	Yii::t('backend', 'Manage'),
);
?>

<h3><?php echo $this->pageTitle; ?></h3>

<?php $this->beginWidget('TbActiveForm', array(
    'id' => 'admin-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php $this->widget('backend.components.AdminView', array(
        'model' => $model,
        'columns' => array(
            'id',
            'title',
            array(
                'name' => 'user_id',
                'value' => '$data->user ? $data->user->title : null',
                'filter' => CHtml::listData(User::model()->findAll(), 'id', 'title'),
            ),
            'preview_text',
            'detail_text',
            'date_create',
            'views',
            'likes',
            'comments',
        ),
    )); ?>

<?php $this->endWidget(); ?>