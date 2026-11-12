<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\UserBook */

$book = $model->book;
$read = (int)$model->status_id === 2;
$rating = (int)$model->rating;
$cover = ($book->id % 8) + 1;
$art = ($book->id % 5) + 1;
$url = Url::to(['site/book', 'id' => $book->id]);
$heart = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg>';
$star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg>';
?>
<article class="book-card">
    <div class="book-card__media">
        <a href="<?= $url ?>" tabindex="-1" aria-hidden="true">
            <div class="art art--<?= $art ?>">
                <div class="book-cover cover--<?= $cover ?>"><span class="book-cover__title"><?= Html::encode($book->name) ?></span></div>
            </div>
        </a>
        <span class="status-badge <?= $read ? 'status-badge--read' : 'status-badge--want' ?>"><?= $read ? 'Прочитано' : 'В планах' ?></span>
        <?= Html::beginForm(['site/favorite', 'id' => $book->id], 'post', ['class' => 'inline-form']) ?>
        <button class="heart" type="submit" aria-pressed="<?= $model->is_favorite ? 'true' : 'false' ?>" aria-label="<?= $model->is_favorite ? 'Убрать из избранного' : 'В избранное' ?>: <?= Html::encode($book->name) ?>"><?= $heart ?></button>
        <?= Html::endForm() ?>
    </div>
    <div class="book-card__body">
        <p class="eyebrow"><?= Html::encode($book->genre->genre) ?></p>
        <h2 class="book-card__title"><a href="<?= $url ?>"><?= Html::encode($book->name) ?></a></h2>
        <p class="book-card__author"><?= Html::encode($book->author) ?></p>
        <div class="book-card__row">
            <div class="rating-view">
                <span class="stars" role="img" aria-label="<?= $rating ? 'Оценка ' . $rating . ' из 5' : 'Оценки пока нет' ?>">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span<?= $i <= $rating ? ' class="is-on"' : '' ?>><?= $star ?></span>
                    <?php endfor; ?>
                </span>
                <?php if ($rating): ?><span><?= $rating ?>.0</span><?php endif; ?>
            </div>
            <a class="btn btn--primary btn--sm" href="<?= $url ?>">Открыть</a>
        </div>
    </div>
</article>
