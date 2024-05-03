<?php

use common\models\Post;
use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/** @var yii\web\View $this */
/** @var common\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'auth_source',),
        ['prompt' => 'Выберите пользователя']);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'text')->widget(Redactor::className()) ?>

<!--    --><?php //= $form->field($model, 'post_category_id')->textInput() ?>
    <?= $form->field($model, 'post_category_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\PostCategory::find()->all(), 'id', 'name',),
        ['prompt' => 'Выберите категорию']);
     ?>


    <!--    --><?php //= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(Post::getStatusOptions(), ['prompt' => 'Выберите статус']); ?>

<!--    --><?php //= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                    'pluginOptions' => ['showUpload' => false,],

                                                    ]);
    ?>
<!--    --><?php //= $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?php //= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
