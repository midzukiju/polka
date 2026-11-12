-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 11 2026 г., 11:41
-- Версия сервера: 8.0.19
-- Версия PHP: 8.0.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `polka`
--

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre_id` int NOT NULL,
  `year_of_publication` smallint DEFAULT NULL,
  `number_of_pages` smallint DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`id`, `name`, `author`, `genre_id`, `year_of_publication`, `number_of_pages`, `description`, `created_at`) VALUES
(1, 'Мастер и Маргарита', 'М. Булгаков', 1, 1967, 480, 'Роман о визите дьявола в Москву 1930-х годов, о любви, которая сильнее страха, и о трусости как самом страшном пороке. Две сюжетные линии — московская сатира и история Понтия Пилата — сходятся в финале.', '2026-10-12 12:00:00'),
(2, 'Краткая история времени', 'С. Хокинг', 4, NULL, NULL, NULL, '2026-10-10 12:00:00'),
(3, 'Маленький принц', 'А. де Сент-Экзюпери', 1, NULL, NULL, '', '2026-10-25 12:00:00'),
(4, 'Собака Баскервилей', 'А. Конан Дойл', 3, NULL, NULL, NULL, '2026-10-26 12:00:00'),
(5, 'Евгений Онегин', 'А. Пушкин', 6, NULL, NULL, NULL, '2026-10-27 12:00:00'),
(6, 'Основание', 'А. Азимов', 2, NULL, NULL, NULL, '2026-10-28 12:00:00'),
(7, 'Преступление и наказание', 'Ф. Достоевский', 1, NULL, NULL, NULL, '2026-10-05 12:00:00'),
(8, 'Хоббит', 'Дж. Р. Р. Толкин', 5, NULL, NULL, NULL, '2026-10-06 12:00:00'),
(9, 'Дюна', 'Ф. Герберт', 2, 1965, 416, NULL, '2026-11-11 10:49:27');

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id`, `genre`) VALUES
(3, 'Детектив'),
(1, 'Классика'),
(4, 'Наука'),
(6, 'Поэзия'),
(2, 'Фантастика'),
(5, 'Фэнтези');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1793953378),
('m261106_100001_create_role_table', 1793953584),
('m261106_100002_create_user_table', 1793953584),
('m261106_100003_create_genre_table', 1793953584),
('m261106_100004_create_status_table', 1793953584),
('m261106_100005_create_book_table', 1793953584),
('m261106_100006_create_user_book_table', 1793953584),
('m261106_100007_create_note_table', 1793953584);

-- --------------------------------------------------------

--
-- Структура таблицы `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `note` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `note`
--

INSERT INTO `note` (`id`, `user_id`, `book_id`, `note`, `created_at`) VALUES
(1, 1, 1, 'Сцена бала у Воланда — любимая. Перечитать главу про Маргариту.', '2026-10-12 20:00:00'),
(2, 1, 1, '«Рукописи не горят» — цитата для эпиграфа к докладу.', '2026-10-20 20:00:00'),
(3, 1, 3, 'Главное глазами не увидишь — зорко одно лишь сердце. Перечитывать раз в год.', '2026-11-02 21:00:00'),
(4, 1, 7, 'Тяжёлая, но сильная книга. Начать с конца первой части, если снова будет сложно войти.', '2026-10-23 22:00:00'),
(5, 3, 1, 'Ершалаимские главы понравились больше московских.', '2026-10-25 23:10:00');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(2, 'admin'),
(3, 'moderator'),
(1, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'В планах'),
(2, 'Прочитано'),
(3, 'Читаю сейчас');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '1',
  `year_goal` smallint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `last_name`, `mail`, `password`, `auth_key`, `role_id`, `year_goal`, `created_at`) VALUES
(1, 'Анна', 'Ковалёва', 'anna.k@mail.ru', '$2y$13$aT6Fu1uuVGGdpBrCRP7AseTozveFvVJJ4Ykr1dMxXieLqVERTFjNS', '', 1, 24, '2026-10-01 10:00:00'),
(2, 'Женя', 'Петрова', 'admin@polka.ru', '$2y$13$aT6Fu1uuVGGdpBrCRP7AseTozveFvVJJ4Ykr1dMxXieLqVERTFjNS', '', 2, 12, '2026-09-20 09:00:00'),
(3, 'Иван', 'Смирнов', 'ivan.s@mail.ru', '$2y$13$aT6Fu1uuVGGdpBrCRP7AseTozveFvVJJ4Ykr1dMxXieLqVERTFjNS', '', 1, 12, '2026-10-15 18:30:00'),
(4, 'Дарина', 'Кириешкина', 'kikiki@ya.ru', '$2y$13$yIB9pM6iwBBz08SqgevFMuAXre1t9xZOp.8oH4wzQGhOah7SVBI1K', 'vCstyVhR02PTdzAlLa1mrQ044teWaZPw', 1, NULL, '2026-11-11 10:53:02');

-- --------------------------------------------------------

--
-- Структура таблицы `user_book`
--

DROP TABLE IF EXISTS `user_book`;
CREATE TABLE `user_book` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `status_id` int NOT NULL DEFAULT '1',
  `rating` tinyint DEFAULT NULL,
  `is_favorite` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_book`
--

INSERT INTO `user_book` (`id`, `user_id`, `book_id`, `status_id`, `rating`, `is_favorite`, `read_at`, `created_at`) VALUES
(1, 1, 1, 2, 5, 1, '2026-10-18', '2026-10-12 12:00:00'),
(2, 1, 2, 1, NULL, 1, NULL, '2026-10-10 12:00:00'),
(3, 1, 3, 2, 5, 1, '2026-11-02', '2026-10-25 12:00:00'),
(4, 1, 4, 1, NULL, 0, NULL, '2026-10-26 12:00:00'),
(5, 1, 5, 2, 5, 0, '2026-10-28', '2026-10-27 12:00:00'),
(6, 1, 6, 1, 5, 0, NULL, '2026-10-28 12:00:00'),
(7, 1, 7, 2, 4, 1, '2026-10-22', '2026-10-05 12:00:00'),
(8, 1, 8, 2, 5, 0, '2026-11-11', '2026-10-06 12:00:00'),
(9, 2, 2, 2, 5, 1, '2026-09-28', '2026-09-22 10:00:00'),
(10, 2, 7, 1, NULL, 0, NULL, '2026-09-25 10:00:00'),
(11, 2, 5, 2, 4, 0, '2026-10-02', '2026-09-30 10:00:00'),
(12, 3, 1, 2, 4, 0, '2026-10-25', '2026-10-16 19:00:00'),
(13, 3, 4, 3, NULL, 0, NULL, '2026-10-20 19:00:00'),
(14, 3, 8, 1, NULL, 1, NULL, '2026-10-22 19:00:00'),
(15, 1, 9, 1, NULL, 0, NULL, '2026-11-11 10:49:27');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_genre` (`genre_id`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genre` (`genre`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_note_user` (`user_id`),
  ADD KEY `fk_note_book` (`book_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- Индексы таблицы `user_book`
--
ALTER TABLE `user_book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_book` (`user_id`,`book_id`),
  ADD KEY `fk_ub_book` (`book_id`),
  ADD KEY `fk_ub_status` (`status_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `note`
--
ALTER TABLE `note`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user_book`
--
ALTER TABLE `user_book`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `fk_book_genre` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

--
-- Ограничения внешнего ключа таблицы `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `fk_note_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_note_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_book`
--
ALTER TABLE `user_book`
  ADD CONSTRAINT `fk_ub_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ub_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `fk_ub_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
