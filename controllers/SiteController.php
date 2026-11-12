<?php

namespace app\controllers;

use app\models\AddBookForm;
use app\models\Book;
use app\models\ContactForm;
use app\models\Genre;
use app\models\LoginForm;
use app\models\Note;
use app\models\ProfileForm;
use app\models\SignupForm;
use app\models\UserBook;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'logout', 'mybooks', 'book', 'add', 'profile', 'favorites',
                    'favorite', 'status', 'rate', 'note-add', 'note-delete', 'remove',
                ],
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'favorite' => ['post'],
                    'status' => ['post'],
                    'rate' => ['post'],
                    'note-add' => ['post'],
                    'note-delete' => ['post'],
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $books = Book::find()->all();
        // var_dump($books);
        return $this->render('index', [ 'books' => $books ]);
    }

    public function actionAuth($tab = 'login')
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('auth', [
            'loginModel' => new LoginForm(),
            'signupModel' => new SignupForm(),
            'tab' => $tab === 'register' ? 'register' : 'login',
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginModel = new LoginForm();
        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            return $this->redirectAfterLogin();
        }

        $loginModel->password = '';
        return $this->render('auth', [
            'loginModel' => $loginModel,
            'signupModel' => new SignupForm(),
            'tab' => 'login',
        ]);
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $signupModel = new SignupForm();
        if ($signupModel->load(Yii::$app->request->post())) {
            $user = $signupModel->signup();
            if ($user !== null) {
                Yii::$app->user->login($user);
                return $this->redirectAfterLogin();
            }
        }

        $signupModel->password = '';
        $signupModel->password2 = '';
        return $this->render('auth', [
            'loginModel' => new LoginForm(),
            'signupModel' => $signupModel,
            'tab' => 'register',
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    private function redirectAfterLogin()
    {
        if (Yii::$app->user->identity->isAdmin()) {
            return $this->redirect(['book/index']);
        }
        return $this->goBack();
    }

    public function actionMybooks($status = null)
    {
        $query = UserBook::find()
            ->with(['book.genre', 'status'])
            ->where(['user_id' => Yii::$app->user->id]);

        if ($status === 'read') {
            $query->andWhere(['status_id' => 2]);
        } elseif ($status === 'want') {
            $query->andWhere(['status_id' => 1]);
        } else {
            $status = null;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 8],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('mybooks', [
            'dataProvider' => $dataProvider,
            'status' => $status,
        ]);
    }

    private function findUserBook($id)
    {
        $userBook = UserBook::find()
            ->with(['book.genre', 'status'])
            // ->where(['user_id' => Yii::$app->user->id, 'book_id' => (int)$id])
            ->where(['book_id' => (int)$id])
            ->one();
        if ($userBook === null) {
            throw new NotFoundHttpException('Книга не найдена.');
        }
        return $userBook;
    }

    public function actionBook($id)
    {
        $userBook = $this->findUserBook($id);
        $notes = Note::find()

        ->where(['user_id' => Yii::$app->user->id, 'book_id' => $userBook->book_id])

            // ->where(['book_id' => $userBook->book_id])
            ->orderBy(['created_at' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        return $this->render('book', ['userBook' => $userBook, 'notes' => $notes]);
    }

    public function actionFavorite($id)
    {
        $userBook = $this->findUserBook($id);
        $userBook->is_favorite = $userBook->is_favorite ? 0 : 1;
        $userBook->save(false);

        $back = Yii::$app->request->referrer;
        if ($back && strpos($back, Yii::$app->request->hostInfo) === 0) {
            return $this->redirect($back);
        }
        return $this->redirect(['site/book', 'id' => $id]);
    }

    public function actionFavorites()
    {
        $query = UserBook::find()
            ->with(['book.genre', 'status'])
            ->where(['user_id' => Yii::$app->user->id, 'is_favorite' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 8],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('favorites', ['dataProvider' => $dataProvider]);
    }

    public function actionStatus($id)
    {
        $userBook = $this->findUserBook($id);
        if ((int)$userBook->status_id === 2) {
            $userBook->status_id = 1;
            $userBook->read_at = null;
        } else {
            $userBook->status_id = 2;
            $userBook->read_at = date('Y-m-d');
        }
        $userBook->save(false);
        return $this->redirect(['site/book', 'id' => $id]);
    }

    public function actionRate($id)
    {
        $userBook = $this->findUserBook($id);
        $rating = (int)Yii::$app->request->post('rating');
        if ($rating >= 1 && $rating <= 5) {
            $userBook->rating = $rating;
            $userBook->save(false);
        }
        return $this->redirect(['site/book', 'id' => $id]);
    }

    public function actionNoteAdd($id)
    {
        $userBook = $this->findUserBook($id);
        $note = new Note();
        $note->user_id = Yii::$app->user->id;
        $note->book_id = $userBook->book_id;
        $note->note = trim((string)Yii::$app->request->post('note'));

        if ($note->save()) {
            Yii::$app->session->setFlash('success', 'Заметка сохранена');
        } else {
            Yii::$app->session->setFlash('error', 'Заметка не может быть пустой или длиннее 500 символов');
        }
        return $this->redirect(['site/book', 'id' => $id]);
    }

    public function actionNoteDelete($id, $note)
    {
        $this->findUserBook($id);
        $model = Note::findOne([
            'id' => (int)$note,
            'user_id' => Yii::$app->user->id,
            'book_id' => (int)$id,
        ]);
        if ($model !== null) {
            $model->delete();
        }
        return $this->redirect(['site/book', 'id' => $id]);
    }

    public function actionRemove($id)
    {
        $userBook = $this->findUserBook($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Note::deleteAll(['user_id' => Yii::$app->user->id, 'book_id' => $userBook->book_id]);
            $userBook->delete();
            $transaction->commit();
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
        Yii::$app->session->setFlash('success', 'Книга удалена с полки');
        return $this->redirect(['site/mybooks']);
    }

    public function actionAdd()
    {
        $model = new AddBookForm();

        if ($model->load(Yii::$app->request->post())) {
            $userBook = $model->save();
            if ($userBook !== null) {
                Yii::$app->session->setFlash('success', 'Книга добавлена на полку');
                return $this->redirect(['site/book', 'id' => $userBook->book_id]);
            }
        }

        $genres = ArrayHelper::map(Genre::find()->orderBy('id')->all(), 'id', 'genre');

        return $this->render('add', ['model' => $model, 'genres' => $genres]);
    }

    public function actionProfile()
    {
        $uid = Yii::$app->user->id;
        $user = Yii::$app->user->identity;
        $model = new ProfileForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Изменения сохранены');
            return $this->redirect(['site/profile']);
        }

        $stats = [
            'total' => (int)UserBook::find()->where(['user_id' => $uid])->count(),
            'read' => (int)UserBook::find()->where(['user_id' => $uid, 'status_id' => 2])->count(),
            'favorites' => (int)UserBook::find()->where(['user_id' => $uid, 'is_favorite' => 1])->count(),
            'notes' => (int)Note::find()->where(['user_id' => $uid])->count(),
        ];

        $recent = UserBook::find()
            ->with('book')
            ->where(['user_id' => $uid, 'status_id' => 2])
            ->orderBy(['read_at' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(3)
            ->all();

        $favorites = UserBook::find()
            ->with(['book.genre', 'status'])
            ->where(['user_id' => $uid, 'is_favorite' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('profile', [
            'user' => $user,
            'model' => $model,
            'stats' => $stats,
            'recent' => $recent,
            'favorites' => $favorites,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
