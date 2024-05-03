<?php

namespace api\modules\v1\controllers;

use api\modules\v1\controllers\AppController;
use common\models\Post;
use common\models\postCategory;
use yii\helpers\Url;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class PostController extends AppController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authentificator' => ['except' => ['index', 'categories']]
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
                'user_id' => $user_id]);

        $query->offset($offset);
        $query->limit($limit);
        $posts = $query->all();

        return $this->returnSuccess([
            'posts' => $posts
        ]);
    }

    public function actionCategories()
    {
        return $this->returnSuccess(postCategory::find()->all(), 'categories');
    }

    public function actionCreate()
    {
        $currentUser = Yii::$app->user->identity;

        $post = new Post();
        if (Yii::$app->request->isPost) {
            $post->user_id = $currentUser->getId();

            $post->title = Yii::$app->request->post('title');
            $post->text = Yii::$app->request->post('text');
            $post->post_category_id = Yii::$app->request->post('post_category_id');
            $post->status = Post::status_brandnew;

            $post->imageFile = UploadedFile::getInstanceByName('image');

            if ($post->save()) {
                return $this->returnSuccess(['post' => $post]);
            } else {
                return $this->returnError('Failed to save post', 500);
            }
        } else {
            return $this->returnError('Invalid request method', 405);
        }
    }

    public function actionUpdate($id)
    {
        $currentUser = Yii::$app->user->identity;
        $post = Post::findOne($id);

        if ($post === null) {
            return $this->returnError('Post not found', 404);
        }

        if ($post->user_id !== $currentUser->id) {
            return $this->returnError('Wrong user_id', 401);
        }

        if (Yii::$app->request->isPut) {

            $postData = Yii::$app->request->getBodyParams();

            foreach ($postData as $key => $value) {
                if (in_array($key, $post->attributes()) && $key !== 'id' && $key !== 'user_id'
                    && $key !== 'status' && $key !== 'created_at' && $key !== 'updated_at') {
                    $post->{$key} = $value;
                }else{
                    return $this->returnError('Incorrect parameter', 500);
                }
            }


            if ($post->save()) {
                return $this->returnSuccess(['post' => $post]);
            } else {
                return $this->returnError('Failed to save post', 500);
            }
        } else {
            return $this->returnError('Invalid request method', 405);
        }

    }
}