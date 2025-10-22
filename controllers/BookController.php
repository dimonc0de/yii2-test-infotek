<?php

namespace app\controllers;

use app\models\Book;
use app\services\author\AuthorService;
use app\services\book\BookService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Book();
        $authorService = new AuthorService();
        $bookService = new BookService();

        $authorsList = $authorService->getListForDropdown();

//      TODO Вынести в сервис
        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate() && $model->save()) {

                $bookService->saveImage($model, $model->imageFile);

                $bookService->saveAuthors($model, $model->authorIds);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->authorIds = [];

        return $this->render('create', [
            'model' => $model,
            'authorsList' => $authorsList,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = Book::findOne($id);
        $authorService = new AuthorService();
        $bookService = new BookService();

        if (!$model) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        $authorsList = $authorService->getListForDropdown();

        $model->authorIds = $model->getAuthors()->select('id')->column();

//      TODO Вынести в сервис
        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate() && $model->save()) {

                $bookService->saveImage($model, $model->imageFile);

                $bookService->saveAuthors($model, $model->authorIds);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'authorsList' => $authorsList,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
