<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use app\models\Genre;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'columns' => [
            'id',
            'name',
            'author',
            [
                'attribute' => 'genre_id',
                'value' => 'genre.genre',
                'filter' => ArrayHelper::map(Genre::find()->orderBy('id')->all(), 'id', 'genre'),
            ],
            'year_of_publication',
            'number_of_pages',
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    return StringHelper::truncate($model->description, 60);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => false,
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>