<?php

use common\models\UserExt;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserExtSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Exts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-ext-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Ext', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'first_name',
            'middle_name',
            'last_name',
            //'phone',
            //'unconfirmed_email:email',
            //'email:email',
            //'email_confirm_token:email',
            //'email_is_verified:email',
            //'email_verified_at:email',
            //'rules_accepted',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UserExt $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
