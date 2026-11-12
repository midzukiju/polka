<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

$route = Yii::$app->controller->route;
$cur = function ($routes) use ($route) {
    return in_array($route, (array)$routes, true) ? ' aria-current="page"' : '';
};
$isGuest = Yii::$app->user->isGuest;
$favCount = $isGuest ? 0 : (int)\app\models\UserBook::find()
    ->where(['user_id' => Yii::$app->user->id, 'is_favorite' => 1])
    ->count();
$heart = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg>';
$logo = '<svg viewBox="0 0 32 32" aria-hidden="true"><rect x="5" y="5" width="6" height="22" rx="1.5"/><rect x="13" y="8" width="6" height="19" rx="1.5"/><path d="M21.5 9.5l5.6 1.6-4.6 15.8-5.6-1.6z"/></svg><span>По<b>лка</b></span>';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= Html::encode($this->title ?: 'Полка — домашняя библиотека') ?></title>
  <meta name="description" content="Домашняя библиотека: добавляйте книги, раскладывайте по полкам, отмечайте прочитанное, ставьте оценки и пишите заметки.">
  <link rel="icon" type="image/svg+xml" href="<?= Yii::getAlias('@web/image/favicon.svg') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Playfair+Display:wght@600;700&amp;display=swap">
  <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/style.css') ?>?v=2">
  <script src="<?= Yii::getAlias('@web/js/main.js') ?>?v=4" defer></script>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<a class="skip-link" href="#main">Перейти к содержимому</a>

<header class="site-header">
  <div class="container site-header__row">
    <a class="logo" href="<?= Url::to(['site/index']) ?>"><?= $logo ?></a>
    <nav class="main-nav" id="main-nav" aria-label="Основная навигация">
      <ul class="main-nav__list">
        <li><a href="<?= Url::to(['site/index']) ?>"<?= $cur('site/index') ?>>Главная</a></li>
        <li><a href="<?= Url::to(['site/mybooks']) ?>"<?= $cur('site/mybooks') ?>>Мои книги</a></li>
        <li><a href="<?= Url::to(['site/add']) ?>"<?= $cur('site/add') ?>>Добавить книгу</a></li>
      </ul>
    </nav>
    <div class="header-actions">
      <a class="icon-btn" href="#" aria-label="Поиск"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg></a>
      <?php if (!$isGuest): ?>
        <a class="icon-btn icon-btn--desktop" href="<?= Url::to(['site/favorites']) ?>" aria-label="Избранное"><?= $heart ?><span class="icon-btn__count"><?= $favCount ?></span></a>
      <?php endif; ?>
      <?php if ($isGuest): ?>
        <a class="btn btn--primary btn--sm" href="<?= Url::to(['site/auth']) ?>">Войти</a>
      <?php else: ?>
        <?php if (Yii::$app->user->identity->isAdmin()): ?>
          <a class="btn btn--secondary btn--sm" href="<?= Url::to(['book/index']) ?>">Админ-панель</a>
        <?php endif; ?>
        <a class="icon-btn icon-btn--desktop" href="<?= Url::to(['site/profile']) ?>" aria-label="Профиль"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg></a>
        <?= Html::beginForm(['site/logout'], 'post') ?>
          <button class="btn btn--secondary btn--sm" type="submit">Выйти</button>
        <?= Html::endForm() ?>
      <?php endif; ?>
      <button class="icon-btn icon-btn--burger" type="button" aria-label="Открыть меню" aria-expanded="false" aria-controls="main-nav" data-nav-toggle><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg></button>
    </div>
  </div>
</header>

<main class="container home-main" id="main">

    <?= $content ?>

</main>

<footer class="site-footer">
  <div class="container">
    <div class="site-footer__grid">
      <div>
        <a class="logo" href="<?= Url::to(['site/index']) ?>"><?= $logo ?></a>
        <p class="small">Домашняя библиотека: книги, полки, оценки и заметки.</p>
      </div>
      <nav aria-label="Разделы сайта">
        <h2 class="site-footer__title">Разделы</h2>
        <ul>
          <li><a href="<?= Url::to(['site/index']) ?>">Главная</a></li>
          <li><a href="<?= Url::to(['site/mybooks']) ?>">Мои книги</a></li>
          <li><a href="<?= Url::to(['site/favorites']) ?>">Избранное</a></li>
          <li><a href="<?= Url::to(['site/profile']) ?>">Профиль</a></li>
        </ul>
      </nav>
      <nav aria-label="Полки">
        <h2 class="site-footer__title">Полки</h2>
        <ul>
          <li><a href="#">Классика</a></li>
          <li><a href="#">Фантастика</a></li>
          <li><a href="#">Детектив</a></li>
          <li><a href="#">Наука</a></li>
        </ul>
      </nav>
      <nav aria-label="Действия">
        <h2 class="site-footer__title">Действия</h2>
        <ul>
          <li><a href="<?= Url::to(['site/add']) ?>">Добавить книгу</a></li>
          <li><a href="#">Поиск</a></li>
          <?php if ($isGuest): ?>
            <li><a href="<?= Url::to(['site/auth']) ?>">Вход / регистрация</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
    <div class="site-footer__bottom">
      <p>© 2026 Полка. Все права защищены.</p>
    </div>
  </div>
</footer>

<nav class="tabbar" aria-label="Нижняя навигация">
  <ul class="tabbar__list">
    <li><a href="<?= Url::to(['site/index']) ?>"<?= $cur('site/index') ?>><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/></svg><span>Главная</span></a></li>
    <li><a href="<?= Url::to(['site/mybooks']) ?>"<?= $cur('site/mybooks') ?>><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="4" height="16" rx="1"/><rect x="10" y="6" width="4" height="14" rx="1"/><path d="M16 7l4 1-3 12-4-1z"/></svg><span>Книги</span></a></li>
    <li><a href="<?= Url::to(['site/add']) ?>" aria-label="Добавить книгу"><span class="tabbar__plus"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></span></a></li>
    <li><a href="<?= Url::to(['site/favorites']) ?>"<?= $cur('site/favorites') ?>><?= $heart ?><span>Избранное</span></a></li>
    <li><a href="<?= Url::to(['site/profile']) ?>"<?= $cur('site/profile') ?>><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg><span>Профиль</span></a></li>
  </ul>
</nav>

<div class="toast" id="toast" role="status" aria-live="polite"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
