<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status string|null */

$this->title = 'Мои книги';

$filters = [
    null => 'Все',
    'read' => 'Прочитано',
    'want' => 'В планах',
];
?>
<nav class="breadcrumbs breadcrumbs--desktop" aria-label="Хлебные крошки">
    <ol>
        <li><a href="<?= Url::to(['site/index']) ?>">Главная</a></li>
        <li aria-current="page">Мои книги</li>
    </ol>
</nav>

<section class="section section--first" aria-labelledby="mybooks-title">
    <div class="section-head">
        <div>
            <h1 id="mybooks-title">Мои книги</h1>
            <p><?= $dataProvider->totalCount ?> на полке</p>
        </div>
    </div>

    <div class="filter" role="group" aria-label="Фильтр по статусу">
        <?php foreach ($filters as $key => $label): ?>
            <?= Html::a(
                Html::encode($label),
                $key === null ? ['site/mybooks'] : ['site/mybooks', 'status' => $key],
                ['class' => 'filter__btn' . ((string)$status === (string)$key ? ' is-active' : '')]
            ) ?>
        <?php endforeach; ?>
    </div>

    <?php if ($dataProvider->count): ?>
        <ul class="book-grid">
            <?php foreach ($dataProvider->getModels() as $userBook): ?>
                <li><?= $this->render('_book_card', ['model' => $userBook]) ?></li>
            <?php endforeach; ?>
        </ul>
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    <?php else: ?>
        <p class="empty-text">В этой категории книг пока нет.</p>
    <?php endif; ?>
</section>
