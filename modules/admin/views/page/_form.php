<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Page;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-xs-12">
                <?= $form->errorSummary($model); ?>
            </div>

            <div class="col-xs-8">
                <?= $form->field($model, 'page_title')->textInput(['maxlength' => true, 'class'=>'form-control act-title']) ?>
                <?= $form->field($model, 'alias')->textInput(['maxlength' => true, 'class'=>'form-control act-title-translit']) ?>
                <?= $form->field($model, 'text')->widget(\vova07\imperavi\Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 200,
                        'fileUpload' => Url::to(['/admin/media/file-upload']),
                        'fileManagerJson' => Url::to(['/admin/media/files-get']),
                        'imageUpload' => Url::to(['/admin/media/file-upload']),
                        'imageManagerJson' => Url::to(['/admin/media/images-get']),
                        'plugins' => [
                            'clips',
                            'fullscreen',
                            'imagemanager',
                            'filemanager'
                        ],
                    ]
                ]); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
                <?= $form->field($model, 'keywords')->textarea(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-4">
                <?= $form->field($model, 'type')->dropDownList(Page::getTypeArray()); ?>
                <?= $form->field($model, 'no_index')->dropDownList(Page::getNoIndexArray()); ?>
                <?= $form->field($model, 'status')->dropDownList(Page::getStatusArray()); ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success full-width' : 'btn btn-primary full-width']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
