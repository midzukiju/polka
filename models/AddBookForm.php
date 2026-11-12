<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddBookForm extends Model
{
    public $title;
    public $author;
    public $genre_id;
    public $year;
    public $pages;
    public $status = 'want';
    public $rating;
    public $description;
    public $favorite;

    public function rules()
    {
        return [
            [['title', 'author', 'genre_id'], 'required'],
            [['title', 'author', 'description'], 'trim'],
            ['title', 'string', 'max' => 120],
            ['author', 'string', 'max' => 80],
            ['description', 'string', 'max' => 1000],
            ['genre_id', 'exist', 'targetClass' => Genre::class, 'targetAttribute' => 'id', 'message' => 'Выберите жанр из списка'],
            ['year', 'integer', 'min' => 1000, 'max' => (int)date('Y') + 1, 'message' => 'Введите год числом', 'tooSmall' => 'Год от 1000', 'tooBig' => 'Год не позже ' . ((int)date('Y') + 1)],
            ['pages', 'integer', 'min' => 1, 'max' => 9999, 'message' => 'Введите число страниц', 'tooSmall' => 'Страниц от 1', 'tooBig' => 'Страниц не больше 9999'],
            ['status', 'in', 'range' => ['want', 'read']],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            ['favorite', 'boolean'],
            [['year', 'pages', 'rating', 'description'], 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'author' => 'Автор',
            'genre_id' => 'Полка / жанр',
            'year' => 'Год издания',
            'pages' => 'Количество страниц',
            'status' => 'Статус',
            'rating' => 'Моя оценка',
            'description' => 'Описание',
            'favorite' => 'Добавить в избранное',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $userId = Yii::$app->user->id;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $book = Book::findOne(['name' => $this->title, 'author' => $this->author]);

            if ($book === null) {
                $book = new Book();
                $book->name = $this->title;
                $book->author = $this->author;
                $book->genre_id = (int)$this->genre_id;
                $book->year_of_publication = $this->year;
                $book->number_of_pages = $this->pages;
                $book->description = $this->description;
                $book->save(false);
            } elseif (UserBook::find()->where(['user_id' => $userId, 'book_id' => $book->id])->exists()) {
                $transaction->rollBack();
                $this->addError('title', 'Эта книга уже есть на вашей полке');
                return null;
            }

            $isRead = $this->status === 'read';

            $userBook = new UserBook();
            $userBook->user_id = $userId;
            $userBook->book_id = $book->id;
            $userBook->status_id = $isRead ? 2 : 1;
            $userBook->rating = $isRead ? $this->rating : null;
            $userBook->is_favorite = $this->favorite ? 1 : 0;
            $userBook->read_at = $isRead ? date('Y-m-d') : null;
            $userBook->save(false);

            $transaction->commit();
            return $userBook;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
