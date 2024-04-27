<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SocialNetwork $model */

$this->title = 'Create Social Network';
$this->params['breadcrumbs'][] = ['label' => 'Social Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-network-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
