<?php

namespace app\actions;

use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class UpdateAction
 */
class UpdateAction extends Action {

    /**
     * @var string Название вьюшки
     */
    public $view = 'update';

    /**
     * @var string Класс
     */
    public $modelClass;

    /**
     * @var string сценарий
     */
    public $modelScenario = 'default';

    /**
     * @var string URL для редиректа после успешного обновления данных
     */
    public $returnUrl = 'update';

    /**
     * @var boolean Флаг, означающий редирект на URL, содержащий ID созданой записи
     */
    public $urlWithId = true;

    /**
     * @var array Дополнительные данные для вьюшки
     */
    public $additionalData = array();

    /**
     * @var string Сообщение при успешном сохранении модели
     */
    public $successMessage = 'Данные успешно сохранены';

    /**
     * @var string Сообщение при неудачном сохранении модели
     */
    public $errorMessage = 'Во время сохранения данных возникла неизвестная ошибка';

    /**
     * @var null Каллбэк
     */
    public $callback = null;

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function run($id) {

        /**
         * @var \app\models\base\BaseActiveRecord|string $modelClass
         */
        $modelClass = $this->modelClass;

        /**
         * @var \app\models\base\BaseActiveRecord|null $model
         */
        $model = $modelClass::findOne($id);

        if (empty($model)) {
            throw new NotFoundHttpException('Такая страница не существует');
        }

        $model->setScenario($this->modelScenario);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                if (is_callable($this->callback)) {
                    return call_user_func($this->callback, $model, $this);
                } else {
                    \Yii::$app->session->setFlash('success', $this->successMessage);

                    if ($this->urlWithId) {
                        return $this->controller->redirect([$this->returnUrl, 'id' => $model->id]);
                    } else {
                        return $this->controller->redirect([$this->returnUrl]);
                    }
                }
            } else {
                \Yii::$app->session->setFlash('error', $this->errorMessage);
                return $this->controller->refresh();
            }
        }


        return $this->controller->render($this->view, ArrayHelper::merge(
            $this->additionalData,
            ['model' => $model]
        ));

    }
}