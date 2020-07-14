<?php

namespace api\modules\v1\controllers;

use frontend\models\search\ArticleSearch;
use api\modules\v1\resources\Article;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\CreateAction;
use yii\rest\UpdateAction;
use yii\rest\DeleteAction;
use yii\rest\Serializer;
use yii\rest\ViewAction;
use yii\web\HttpException;
use yii\filters\auth\HttpBasicAuth;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     basePath="/napi/v1/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Multi-language Digital Documentation API Reference",
 *         description="文献系统的 Article（文章）API 说明文档。仅供学习研究使用。",
 *         termsOfService="",
 *         @SWG\License(
 *             name="BSD License",
 *             url="###"
 *         )
 *     ),
 * )
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'api\modules\v1\resources\Article';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'only' => ['create', 'update']
        ];
        return $behaviors;
    }

    /**
     * @SWG\Get(path="/article/index",
     *     tags={"Article"},
     *     summary="查询文章集合。如需组合查询，可以使用 filter[parm1]=a&filter[parm2]=b 的方式",
     *     @SWG\Parameter(
     *          name="filter[id]",
     *          type="integer",
     *          required=false,
     *          in="query",
     *          description="文章ID"
     *     ),
     *     @SWG\Parameter(
     *          name="filter[title]",
     *          type="string",
     *          required=false,
     *          in="query",
     *          description="文章标题。如果要使用部分匹配，请将参数改为 filter[title][like] "
     *     ),
     *     @SWG\Parameter(
     *          name="filter[slug]",
     *          type="string",
     *          required=false,
     *          in="query",
     *          description="文章slug。如果要使用部分匹配，请将参数改为 filter[slug][like] "
     *     ),
     *     @SWG\Parameter(
     *          name="filter[category_id]",
     *          type="integer",
     *          required=false,
     *          in="query",
     *          description="文章分类ID"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Article collection response",
     *         @SWG\Schema(ref = "#/definitions/Article")
     *     ),
     * )
     *
     * @SWG\Get(path="/article/view",
     *     tags={"Article"},
     *     summary="查询指定ID的文章",
     *     @SWG\Parameter(
     *          name="id",
     *          type="integer",
     *          required=false,
     *          in="query",
     *          description="文章ID"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "取回指定ID的 article 实例.",
     *         @SWG\Schema(ref = "#/definitions/Article")
     *     ),
     * )
     * 
     * @SWG\Post(path="/article/create",
     *     tags={"Article"},
     *     summary="创建文章，注意JSON里不要包含ID",
     *     @SWG\Parameter(
     *          name="body",
     *          type="string",
     *          required=true,
     *          in="body",
     *          description="文章Model JSON",
     *          @SWG\Schema(ref = "#/definitions/Article")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "已创建的 article 实例.",
     *         @SWG\Schema(ref = "#/definitions/Article")
     *     )
     * )
     * 
     * @SWG\Put(path="/article/update",
     *     tags={"Article"},
     *     summary="修改指定ID的文章",
     *     @SWG\Parameter(
     *          name="id",
     *          type="integer",
     *          required=true,
     *          in="query",
     *          description="文章ID"
     *     ),
     *     @SWG\Parameter(
     *          name="body",
     *          type="string",
     *          required=true,
     *          in="body",
     *          description="文章Model JSON",
     *          @SWG\Schema(ref = "#/definitions/Article")
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "已修改的 article 实例.",
     *         @SWG\Schema(ref = "#/definitions/Article")
     *     )
     * )
     * 
     * @SWG\Options(path="/article/options",
     *     tags={"Article"},
     *     summary="显示关于当前资源的所有可选的指令",
     *     @SWG\Parameter(
     *          name="id",
     *          type="integer",
     *          required=false,
     *          in="query",
     *          description="文章ID"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "关于当前资源的所有可选的指令。参考Response Header Allow",
     *     ),
     * )
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
                'dataFilter' => [
                    'class' => 'yii\data\ActiveDataFilter',
                    'searchModel' => ArticleSearch::class
                ]
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => OptionsAction::class,

            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass,
            ],
            'update' => [
                'class' => UpdateAction::class,
                'modelClass' => $this->modelClass,
            ],
        ];
    }

    /**
     * @return ActiveDataProvider
     * 
     * http://mldigidoc.locl/napi/v1/article/index?filter[id]=1
     * http://mldigidoc.locl/napi/v1/article/index?filter[category_id]=1
     * http://mldigidoc.locl/napi/v1/article/index?filter[title]=aaaa
     * http://mldigidoc.locl/napi/v1/article/index?filter[title][like]=a
     * http://mldigidoc.locl/napi/v1/article/index?filter[slug]=aaaa
     * http://mldigidoc.locl/napi/v1/article/index?filter[slug][like]=a
     */
    public function prepareDataProvider($action, $filter)
    {
        $query = Article::find()->with('category', 'articleAttachments')->published();
        if($filter){
            $query->andWhere($filter);
        }
        return new ActiveDataProvider(array(
            'query' => $query
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = Article::find()
            ->published()
            ->andWhere(['id' => (int)$id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}
