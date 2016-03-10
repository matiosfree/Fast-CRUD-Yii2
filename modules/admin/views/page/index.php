<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'page_title',
            'description',
            'alias',
            'description',
            'no_index' => [
                'attribute' => 'no_index',
                'value' => function($data) {
                    /** @var $data \app\models\Page */
                    return $data->getNoIndexTitle();
                }
            ],
            'type' => [
                'attribute' => 'type',
                'value' => function($data) {
                    /** @var $data \app\models\Page */
                    return $data->getTypeTitle();
                }
            ],
            'status' => [
                'attribute' => 'status',
                'value' => function($data) {
                    /** @var $data \app\models\Page */
                    return $data->getStatusTitle();
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>

</div>
