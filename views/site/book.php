<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $userBook app\models\UserBook */
/* @var $notes app\models\Note[] */

$book = $userBook->book;
$this->title = $book->name . ' — Полка';

$read = (int)$userBook->status_id === 2;
$rating = (int)$userBook->rating;
$fav = (bool)$userBook->is_favorite;
$cover = ($book->id % 8) + 1;
$art = ($book->id % 5) + 1;
$genre = $book->genre ? $book->genre->genre : '—';
$fmt = Yii::$app->formatter;

$heart = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg>';
$star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg>';
$id = $book->id;
?>
<div class="container">

    <nav class="breadcrumbs breadcrumbs--desktop" aria-label="Хлебные крошки">
        <ol>
            <li><a href="<?= Url::to(['site/index']) ?>">Главная</a></li>
            <li><a href="<?= Url::to(['site/mybooks']) ?>">Мои книги</a></li>
            <li aria-current="page"><?= Html::encode($book->name) ?></li>
        </ol>
    </nav>

    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <p class="flash flash--<?= Html::encode($type) ?>" role="status"><?= Html::encode($message) ?></p>
    <?php endforeach; ?>

    <div class="book-layout">

        <div class="book-layout__side">
            <div class="book-cover-box">
                <div class="art art--<?= $art ?>">
                    <div class="book-cover cover--<?= $cover ?>"><span class="book-cover__title"><?= Html::encode($book->name) ?></span></div>
                </div>
            </div>

            <section class="box" aria-labelledby="details-title">
                <div class="box__head"><h2 id="details-title">Детали</h2></div>
                <dl class="detail-list">
                    <div class="detail-list__row"><dt>Автор</dt><dd><?= Html::encode($book->author) ?></dd></div>
                    <div class="detail-list__row"><dt>Полка / жанр</dt><dd><?= Html::encode($genre) ?></dd></div>
                    <?php if ($book->year_of_publication): ?>
                        <div class="detail-list__row"><dt>Год издания</dt><dd><?= (int)$book->year_of_publication ?></dd></div>
                    <?php endif; ?>
                    <?php if ($book->number_of_pages): ?>
                        <div class="detail-list__row"><dt>Страниц</dt><dd><?= (int)$book->number_of_pages ?></dd></div>
                    <?php endif; ?>
                    <div class="detail-list__row"><dt>Добавлена</dt><dd><?= $fmt->asDate($userBook->created_at, 'php:d.m.Y') ?></dd></div>
                    <div class="detail-list__row"><dt>Заметок</dt><dd><?= count($notes) ?></dd></div>
                </dl>
            </section>
        </div>

        <div class="book-layout__main">

            <article class="box book-info">
                <p class="eyebrow"><?= Html::encode($genre) ?></p>
                <h1><?= Html::encode($book->name) ?></h1>
                <p class="book-info__author"><?= Html::encode($book->author) ?><?= $book->year_of_publication ? ', ' . (int)$book->year_of_publication : '' ?></p>
                <ul class="badge-list">
                    <li class="badge badge--genre"><?= Html::encode($genre) ?></li>
                    <li class="badge <?= $read ? 'badge--read' : '' ?>"><?= $read ? 'Прочитано' : 'В планах' ?></li>
                    <?php if ($book->number_of_pages): ?>
                        <li class="badge"><?= (int)$book->number_of_pages ?> стр.</li>
                    <?php endif; ?>
                </ul>

                <div class="rating-row">
                    <?= Html::beginForm(['site/rate', 'id' => $id], 'post', ['class' => 'inline-form']) ?>
                    <div class="rating-input" role="group" aria-label="Моя оценка">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <button type="submit" name="rating" value="<?= $i ?>" class="<?= $i <= $rating ? 'is-on' : '' ?>" aria-label="Оценка <?= $i ?> из 5"><?= $star ?></button>
                        <?php endfor; ?>
                    </div>
                    <?= Html::endForm() ?>
                    <span class="rating-row__value"><?= $rating ? $rating . '.0' : '—' ?></span>
                    <span class="small muted">моя оценка</span>
                </div>

                <?php if ($book->description): ?>
                    <p class="book-info__desc"><?= nl2br(Html::encode($book->description)) ?></p>
                <?php endif; ?>

                <div class="status-box">
                    <div>
                        <p class="status-box__title"><?= $read ? 'Я прочитал(а) эту книгу' : 'Книга в планах' ?></p>
                        <?php if ($read && $userBook->read_at): ?>
                            <p class="status-box__sub">Отмечено <?= $fmt->asDate($userBook->read_at, 'php:d.m.Y') ?></p>
                        <?php endif; ?>
                    </div>
                    <?= Html::beginForm(['site/status', 'id' => $id], 'post', ['class' => 'inline-form']) ?>
                    <button class="btn btn--secondary btn--sm" type="submit"><?= $read ? 'Вернуть в планы' : 'Отметить прочитанной' ?></button>
                    <?= Html::endForm() ?>
                </div>

                <div class="book-actions">
                    <?= Html::beginForm(['site/favorite', 'id' => $id], 'post', ['class' => 'inline-form']) ?>
                    <button class="btn btn--primary" type="submit" aria-pressed="<?= $fav ? 'true' : 'false' ?>"><?= $heart ?><span><?= $fav ? 'Убрать из избранного' : 'В избранное' ?></span></button>
                    <?= Html::endForm() ?>

                    <?= Html::beginForm(['site/remove', 'id' => $id], 'post', ['class' => 'inline-form', 'onsubmit' => 'return confirm("Удалить книгу из моей полки вместе с заметками?");']) ?>
                    <button class="btn btn--danger" type="submit">Удалить</button>
                    <?= Html::endForm() ?>
                </div>
            </article>

            <section class="box" aria-labelledby="notes-title">
                <div class="box__head">
                    <h2 id="notes-title">Мои заметки</h2>
                    <span class="count-badge"><?= count($notes) ?></span>
                </div>

                <?php if ($notes): ?>
                    <ul class="note-list">
                        <?php foreach ($notes as $n): ?>
                            <li class="note">
                                <div class="note__head">
                                    <time class="note__date" datetime="<?= Html::encode($fmt->asDate($n->created_at, 'php:Y-m-d')) ?>"><?= $fmt->asDate($n->created_at, 'php:d.m.Y') ?></time>
                                    <?= Html::beginForm(['site/note-delete', 'id' => $id, 'note' => $n->id], 'post', ['class' => 'inline-form']) ?>
                                    <button class="link-btn" type="submit">Удалить</button>
                                    <?= Html::endForm() ?>
                                </div>
                                <p><?= nl2br(Html::encode($n->note)) ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="empty-text">Заметок пока нет.</p>
                <?php endif; ?>

                <?= Html::beginForm(['site/note-add', 'id' => $id], 'post') ?>
                <div class="field">
                    <label for="note-text">Новая заметка</label>
                    <textarea class="textarea" id="note-text" name="note" maxlength="500" required placeholder="Мысли, цитаты, впечатления…"></textarea>
                </div>
                <button class="btn btn--primary" type="submit">Сохранить заметку</button>
                <?= Html::endForm() ?>
            </section>

        </div>
    </div>
</div>
