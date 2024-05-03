<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\AppController;
use common\models\Post;
use yii\helpers\ArrayHelper;

class PostController extends AppController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authentificator' => ['except' => ['index']]
        ]);
    }

    public function actionIndex()
    {
        return $this->returnSuccess([
            'posts' => Post::find()->all()
        ]);
    }
}