<?php
namespace frontend\controllers;

use common\models\Category;
use common\models\Page;
use common\models\Post;
use common\models\Tag;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $pagination=new Pagination([
            'totalCount'=>Post::find()->count(),
        ]);
        $posts=Post::find()->published()->with('categories')->with('tags')->with('author')->orderByCid()->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('list',['posts'=>$posts,'pagination'=>$pagination]);
    }

    public function actionPost($id){
        $post=Post::find()->andWhere(['cid'=>$id])->published()->one();
        if(!$post){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->render('post',['post'=>$post]);
    }

    public function actionPage($slug){
        $page=Page::find()->andWhere(['slug'=>$slug])->one();
        if(!$page){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->render('page',['page'=>$page]);

    }

    public function actionCategory($slug){
        $category=Category::find()->andWhere(['slug'=>$slug])->one();
        if(!$category){
            throw new NotFoundHttpException('页面不存在');
        }
        $pagination=new Pagination([
            'totalCount'=>$category->getPosts()->count()
        ]);
        $posts=$category->getPosts()->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('list',[
            'posts'=>$posts,
            'pagination'=>$pagination,
            'category'=>$category]);
    }

    public function actionTag($slug){
        $tag=Tag::find()->andWhere(['slug'=>$slug])->one();
        if(!$tag){
            throw new NotFoundHttpException('页面不存在');
        }
        $pagination=new Pagination([
            'totalCount'=>$tag->getPosts()->count()
        ]);
        $posts=$tag->getPosts()->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('list',[
            'posts'=>$posts,
            'pagination'=>$pagination,
            'tag'=>$tag]);
    }

    public function actionAuthor($name){
        $author=User::find()->where(['name'=>$name])->one();
        if(!$author){
            throw new NotFoundHttpException('页面不存在');
        }
        $pagination=new Pagination([
            'totalCount'=>$author->getPosts()->count()
        ]);
        $posts=$author->getPosts()->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('list',[
            'posts'=>$posts,
            'pagination'=>$pagination,
            'author'=>$author]);
    }

    public function actionError()
    {
        $this->layout=false;
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }


}
