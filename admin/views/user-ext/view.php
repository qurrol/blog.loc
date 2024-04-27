<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\UserExt $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-ext-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'first_name',
            'middle_name',
            'last_name',
            'phone',
            'unconfirmed_email:email',
            'email:email',
            'email_confirm_token:email',
            'email_is_verified:email',
            'email_verified_at:email',
            'rules_accepted',
        ],
    ]) ?>

</div>
