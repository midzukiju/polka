<section class="hero" aria-labelledby="hero-title">
  <div>
    <p class="pill">Моя полка · осень</p>
    <h1 id="hero-title">Книги, к которым хочется возвращаться</h1>
    <p class="hero__lead">Добавляй книги, раскладывай по полкам и жанрам, отмечай прочитанное, ставь оценки и храни заметки в одном месте.</p>
    <div class="hero__actions">
      <a class="btn btn--primary" href="add">Добавить книгу</a>
      <a class="btn btn--secondary" href="mybooks">Мои книги</a>
    </div>
    <ul class="stat-row">
      <li><span class="stat-row__num">10</span><span class="stat-row__label">книг на полке</span></li>
      <li><span class="stat-row__num">6</span><span class="stat-row__label">прочитано</span></li>
      <li><span class="stat-row__num">4.7</span><span class="stat-row__label">средняя оценка</span></li>
    </ul>
  </div>
  <div class="hero__art">
    <img class="auth__photo" src="<?= Yii::getAlias('@web/image/hero.jpg') ?>" width="736" height="816" alt="Раскрытые книги, разложенные на ткани с цветочным узором">
    <div class="hero__badge">
      <span class="hero__badge-icon" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M5 12l5 5 9-10" />
        </svg></span>
      <p><strong>6 прочитано</strong><span>из твоей библиотеки</span></p>
    </div>
  </div>
</section>

<section class="section" aria-labelledby="genres-title">
  <div class="section-head">
    <div>
      <h2 id="genres-title">Полки и жанры</h2>
      <p>Выбери полку, чтобы увидеть книги</p>
    </div>
  </div>
  <ul class="tile-grid">
    <li>
      <a class="tile" href="#">
        <span class="tile__art art--1" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 9l9-5 9 5" />
            <path d="M5 9v9M9 9v9M15 9v9M19 9v9" />
            <path d="M3 20h18" />
          </svg></span>
        <span class="tile__name">Классика</span>
        <span class="tile__count">3 книги</span>
      </a>
    </li>
    <li>
      <a class="tile" href="#">
        <span class="tile__art art--5" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 3c3 2 5 5 5 9l-2 3H9l-2-3c0-4 2-7 5-9z" />
            <circle cx="12" cy="10" r="1.6" />
            <path d="M9 15l-3 3 1 3 3-2M15 15l3 3-1 3-3-2" />
          </svg></span>
        <span class="tile__name">Фантастика</span>
        <span class="tile__count">2 книги</span>
      </a>
    </li>
    <li>
      <a class="tile" href="#">
        <span class="tile__art art--3" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="6" />
            <path d="M20 20l-4.5-4.5" />
            <path d="M8.5 11a2.5 2.5 0 0 1 2.5-2.5" />
          </svg></span>
        <span class="tile__name">Детектив</span>
        <span class="tile__count">2 книги</span>
      </a>
    </li>
    <li>
      <a class="tile" href="#">
        <span class="tile__art art--4" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 13l12-6 2 4-12 6z" />
            <path d="M15 7l2-1 3 6-2 1" />
            <path d="M9 17l-2 4M12 15l3 6" />
          </svg></span>
        <span class="tile__name">Наука</span>
        <span class="tile__count">1 книга</span>
      </a>
    </li>
    <li>
      <a class="tile" href="#">
        <span class="tile__art art--2" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8z" />
            <path d="M19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8z" />
          </svg></span>
        <span class="tile__name">Фэнтези</span>
        <span class="tile__count">1 книга</span>
      </a>
    </li>
    <li>
      <a class="tile" href="#">
        <span class="tile__art art--1" aria-hidden="true"><svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M20 4c-8 0-13 5-13 12v4" />
            <path d="M20 4c0 8-5 13-12 13" />
            <path d="M7 20l7-7" />
          </svg></span>
        <span class="tile__name">Поэзия</span>
        <span class="tile__count">1 книга</span>
      </a>
    </li>
  </ul>
</section>

<section class="section" aria-labelledby="recent-title">
  <div class="section-head">
    <div>
      <h2 id="recent-title">Недавно добавленные</h2>
      <p>Свежие поступления на твоей полке</p>
    </div>
    <a class="btn btn--secondary btn--sm" href="mybooks">Все книги</a>
  </div>
  <ul class="book-grid">
    <?php

                                    use yii\helpers\Url;
  $i = 1;
 foreach ($books as $book) {
  $i++;
  if($i > 5) { break; } 
  ?>
      <li>
        <article class="book-card">
          <div class="book-card__media">
            <a href="book" tabindex="-1" aria-hidden="true">
              <div class="art art--1">
                <div class="book-cover cover--<?= $i ?>"><span class="book-cover__title"><?= $book->name ?></span></div>
              </div>
            </a>
            <span class="status-badge status-badge--read">Прочитано</span>
            <button class="heart" type="button" data-fav="prince" aria-pressed="true" aria-label="В избранное: Маленький принц"><svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z" />
              </svg></button>
          </div>
          <div class="book-card__body">
            <p class="eyebrow"><?= $book->genre->genre ?></p>
            <h3 class="book-card__title"><a href="book"><?= $book->name ?></a></h3>
            <p class="book-card__author"><?= $book->author ?></p>
            <div class="book-card__row">
              <div class="rating-view"><span class="stars" role="img" aria-label="Оценка 5 из 5"><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z" />
                    </svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z" />
                    </svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z" />
                    </svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z" />
                    </svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true">
                      <path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z" />
                    </svg></span></span><span>5.0</span></div>
              <a class="btn btn--primary btn--sm" href="<?= Url::to(['site/book?id='.$book->id]) ?>">Открыть</a>
            </div>
          </div>
        </article>
      </li>
    <?php } ?>

    <!-- <li>
        <article class="book-card">
          <div class="book-card__media">
            <a href="book" tabindex="-1" aria-hidden="true">
              <div class="art art--1"><div class="book-cover cover--3"><span class="book-cover__title">Маленький принц</span></div></div>
            </a>
            <span class="status-badge status-badge--read">Прочитано</span>
            <button class="heart" type="button" data-fav="prince" aria-pressed="true" aria-label="В избранное: Маленький принц"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg></button>
          </div>
          <div class="book-card__body">
            <p class="eyebrow">Классика</p>
            <h3 class="book-card__title"><a href="book">Маленький принц</a></h3>
            <p class="book-card__author">А. де Сент-Экзюпери</p>
            <div class="book-card__row">
              <div class="rating-view"><span class="stars" role="img" aria-label="Оценка 5 из 5"><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span></span><span>5.0</span></div>
              <a class="btn btn--primary btn--sm" href="book">Открыть</a>
            </div>
          </div>
        </article>
      </li> -->
    <!-- <li>
        <article class="book-card">
          <div class="book-card__media">
            <a href="book" tabindex="-1" aria-hidden="true">
              <div class="art art--3"><div class="book-cover cover--4"><span class="book-cover__title">Собака Баскервилей</span></div></div>
            </a>
            <span class="status-badge status-badge--want">В планах</span>
            <button class="heart" type="button" data-fav="baskerville" aria-pressed="false" aria-label="В избранное: Собака Баскервилей"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg></button>
          </div>
          <div class="book-card__body">
            <p class="eyebrow">Детектив</p>
            <h3 class="book-card__title"><a href="book">Собака Баскервилей</a></h3>
            <p class="book-card__author">А. Конан Дойл</p>
            <div class="book-card__row">
              <div class="rating-view"><span class="stars" role="img" aria-label="Оценки пока нет"><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span></span></div>
              <a class="btn btn--primary btn--sm" href="book">Открыть</a>
            </div>
          </div>
        </article>
      </li>
      <li>
        <article class="book-card">
          <div class="book-card__media">
            <a href="book" tabindex="-1" aria-hidden="true">
              <div class="art art--4"><div class="book-cover cover--1"><span class="book-cover__title">Евгений Онегин</span></div></div>
            </a>
            <span class="status-badge status-badge--read">Прочитано</span>
            <button class="heart" type="button" data-fav="onegin" aria-pressed="false" aria-label="В избранное: Евгений Онегин"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg></button>
          </div>
          <div class="book-card__body">
            <p class="eyebrow">Поэзия</p>
            <h3 class="book-card__title"><a href="book">Евгений Онегин</a></h3>
            <p class="book-card__author">А. Пушкин</p>
            <div class="book-card__row">
              <div class="rating-view"><span class="stars" role="img" aria-label="Оценка 5 из 5"><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span class="is-on"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span></span><span>5.0</span></div>
              <a class="btn btn--primary btn--sm" href="book">Открыть</a>
            </div>
          </div>
        </article>
      </li>
      <li>
        <article class="book-card">
          <div class="book-card__media">
            <a href="book" tabindex="-1" aria-hidden="true">
              <div class="art art--5"><div class="book-cover cover--2"><span class="book-cover__title">Основание</span></div></div>
            </a>
            <span class="status-badge status-badge--want">В планах</span>
            <button class="heart" type="button" data-fav="foundation" aria-pressed="false" aria-label="В избранное: Основание"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-9-9.2C1.8 7.6 3.8 4.5 7 4.5c2 0 3.4 1 5 3 1.6-2 3-3 5-3 3.2 0 5.2 3.1 4 6.3C19 15.6 12 20 12 20z"/></svg></button>
          </div>
          <div class="book-card__body">
            <p class="eyebrow">Фантастика</p>
            <h3 class="book-card__title"><a href="book">Основание</a></h3>
            <p class="book-card__author">А. Азимов</p>
            <div class="book-card__row">
              <div class="rating-view"><span class="stars" role="img" aria-label="Оценки пока нет"><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span><span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.8l2.8 5.9 6.4.9-4.6 4.5 1.1 6.4L12 17.4l-5.7 3.1 1.1-6.4L2.8 9.6l6.4-.9z"/></svg></span></span></div>
              <a class="btn btn--primary btn--sm" href="book">Открыть</a>
            </div>
          </div>
        </article>
      </li> -->
  </ul>
</section>

<section class="promo" aria-labelledby="promo-title">
  <div class="promo__text">
    <p class="pill">Цель на год</p>
    <h2 id="promo-title">Собери свою читательскую полку</h2>
    <p>Отмечай прочитанное, ставь оценки и пиши заметки, чтобы не забыть любимые цитаты.</p>
    <a class="btn btn--primary" href="add ">Добавить книгу</a>
  </div>
  <div class="promo__art" aria-hidden="true">
    <div class="book-cover cover--1"><span class="book-cover__title">Моя любимая книга</span></div>
  </div>
</section>