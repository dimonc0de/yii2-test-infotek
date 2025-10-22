<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Подписка на автора';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="subscription-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phone')->textInput(['placeholder' => '79939228322']) ?>

    <div class="form-group">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>