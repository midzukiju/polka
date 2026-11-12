<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BookSearch represents the model behind the search form of `app\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genre_id', 'year_of_publication', 'number_of_pages'], 'integer'],
            [['name', 'author', 'description', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find()->joinWith('genre');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
        ]);

        $dataProvider->sort->attributes['genre_id'] = [
            'asc' => ['genre.genre' => SORT_ASC],
            'desc' => ['genre.genre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'book.id' => $this->id,
            'book.genre_id' => $this->genre_id,
            'book.year_of_publication' => $this->year_of_publication,
            'book.number_of_pages' => $this->number_of_pages,
        ]);

        $query->andFilterWhere(['like', 'book.name', $this->name])
            ->andFilterWhere(['like', 'book.author', $this->author])
            ->andFilterWhere(['like', 'book.description', $this->description]);

        return $dataProvider;
    }
}