<?php

use common\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return !empty($model->user->auth_source) ? : null;
                },
            ],
            'title',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusOptions()[$model->status];
                },
            ],
            [
                'attribute' => 'post_category_id',
                'value' => function ($model) {
                    return $model->postCategory->name;
                },
            ],
            [
                'attribute' => Yii::t('app', 'image'),
                'format' => 'raw',
                'value' => function ($model) {
                    $imageUrl = !empty($model->image) ? '/uploads/' . '/' . $model->image : null;
                    return $imageUrl ? Html::img($imageUrl, ['alt' => 'Картинка', 'style' => 'width:70px;']) : 'null';
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'user_id' => $model->user_id]);
                }
            ],
        ],
    ]); ?>


</div>
