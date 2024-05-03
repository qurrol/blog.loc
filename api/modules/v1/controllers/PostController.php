<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\AppController;
use common\models\Post;
use yii\helpers\Url;
use Yii;
use yii\helpers\ArrayHelper;

class PostController extends AppController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authentificator' => ['except' => ['index']]
        ]);
    }

    public function actionIndex($id = null, $post_category_id = null, $offset = null, $limit = null, $user_id = null)
    {
        if ($id !== null) {
            $post = Post::findOne($id);
            if ($post) {
                return $this->returnSuccess(['post' => $post]);
            } else {
                return $this->returnError('Post not found', 404);
            }
        }
        $query = Post::find()->joinWith('postCategory')
            ->where(['post.status' => Post::status_published])
            ->orderBy(['created_at' => SORT_DESC])
            ->andFilterWhere(['post_category_id' => $post_category_id,
                              'user_id' => $user_id])
        ;

        $query->offset($offset);
        $query->limit($limit);
        $posts = $query->all();

        return $this->returnSuccess([
            'posts' => $posts
        ]);
    }
}