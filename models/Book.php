<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string $author
 * @property int $genre_id
 * @property int|null $year_of_publication
 * @property int|null $number_of_pages
 * @property string|null $description
 * @property string $created_at
 *
 * @property Genre $genre
 * @property Note[] $notes
 * @property UserBook[] $userBooks
 * @property User[] $users
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['name', 'author', 'genre_id'], 'required'],
        [['genre_id'], 'integer'],
        [['year_of_publication'], 'integer', 'min' => 1000, 'max' => 2100],
        [['number_of_pages'], 'integer', 'min' => 1, 'max' => 9999],
        [['description'], 'string'],
        [['created_at'], 'safe'],
        [['name', 'author'], 'string', 'max' => 255],
        [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_id' => 'id']],
    ];
}

public function attributeLabels()
{
    return [
        'id' => 'ID',
        'name' => 'Название',
        'author' => 'Автор',
        'genre_id' => 'Жанр',
        'year_of_publication' => 'Год издания',
        'number_of_pages' => 'Страниц',
        'description' => 'Описание',
        'created_at' => 'Добавлена',
    ];
}

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[Notes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['book_id' => 'id']);
    }

    /**
     * Gets query for [[UserBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserBooks()
    {
        return $this->hasMany(UserBook::className(), ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_book', ['book_id' => 'id']);
    }
}
