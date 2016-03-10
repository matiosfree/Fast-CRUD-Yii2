<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller {

    public $layout = '@app/modules/admin/views/layouts/main';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'index' => [
                'class' => 'app\actions\IndexAction',
                'modelClass' => 'app\models\Page'
            ],
            'create' => [
                'class' => 'app\actions\CreateAction',
                'modelClass' => 'app\models\Page'
            ],
            'update' => [
                'class' => 'app\actions\UpdateAction',
                'modelClass' => 'app\models\Page'
            ],
            'delete' => [
                'class' => 'app\actions\DeleteAction',
                'modelClass' => 'app\models\Page'
            ],
            'view' => [
                'class' => 'app\actions\ViewAction',
                'modelClass' => 'app\models\Page'
            ],
        ];
    }
}
