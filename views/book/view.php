<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить эту книгу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'author',
            ['attribute' => 'genre_id', 'value' => $model->genre->genre],
            'year_of_publication',
            'number_of_pages',
            'description:ntext',
            ['attribute' => 'created_at', 'format' => ['date', 'php:d.m.Y']],
            ['label' => 'Добавили на полку', 'value' => count($model->userBooks)],
            ['label' => 'Заметок', 'value' => count($model->notes)],
        ],
    ]) ?>

    <h2>Заметки к книге</h2>
    <?php if ($model->notes): ?>
        <ul>
            <?php foreach ($model->notes as $note): ?>
                <li>
                    <?= Html::encode($note->note) ?>
                    <small>— <?= Html::encode($note->user->name) ?>, <?= Yii::$app->formatter->asDate($note->created_at, 'php:d.m.Y') ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Заметок пока нет.</p>
    <?php endif; ?>

</div>