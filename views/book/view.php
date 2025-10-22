<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
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
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'publish_date',
            'description:ntext',
            'isbn',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?php if ($model->mainImage): ?>
        <p>
            <?= Html::img('@web' . $model->mainImage->image_path, ['alt' => $model->title, 'style' => 'max-width:200px;']) ?>
        </p>
    <?php endif; ?>

</div>
