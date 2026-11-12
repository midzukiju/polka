<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Избранное — Полка';
?>
<nav class="breadcrumbs breadcrumbs--desktop" aria-label="Хлебные крошки">
    <ol>
        <li><a href="<?= Url::to(['site/index']) ?>">Главная</a></li>
        <li aria-current="page">Избранное</li>
    </ol>
</nav>

<section class="section section--first" aria-labelledby="fav-title">
    <div class="section-head">
        <div>
            <h1 id="fav-title">Избранное</h1>
            <p><?= $dataProvider->totalCount ?> в избранном</p>
        </div>
    </div>

    <?php if ($dataProvider->count): ?>
        <ul class="book-grid">
            <?php foreach ($dataProvider->getModels() as $userBook): ?>
                <li><?= $this->render('_book_card', ['model' => $userBook]) ?></li>
            <?php endforeach; ?>
        </ul>
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    <?php else: ?>
        <p class="empty-text">Пока ничего нет. Нажмите на сердечко у книги, чтобы добавить её сюда.</p>
    <?php endif; ?>
</section>
