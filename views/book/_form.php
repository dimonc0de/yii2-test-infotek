<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $authorsList */

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publish_date')->input('date') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*'])->label('Загрузить изображение') ?>

    <?= $form->field($model, 'authorIds')->checkboxList(
            $authorsList
    )->label('Авторы') ?>

    <div class="form-group">

        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
