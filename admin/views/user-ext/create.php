<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserExt $model */

$this->title = 'Create User Ext';
$this->params['breadcrumbs'][] = ['label' => 'User Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-ext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
