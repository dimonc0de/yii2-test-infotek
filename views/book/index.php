<?php

use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'publish_date',
            'description:ntext',
            'isbn',
            //'created_at',
            //'updated_at',
            [
                    'class' => ActionColumn::class,
                    'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
                    'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
            ],
        ],
    ]); ?>


</div>
