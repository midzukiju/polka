<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'columns' => [
            'id',
            'name',
            'last_name',
            'mail',
            ['attribute' => 'role_id', 'value' => 'role.role'],
            'year_goal',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y'],
                'filter' => false,
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>