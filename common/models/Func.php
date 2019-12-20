<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "func".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property integer $created_by
 *
 * @property \common\models\User $createdBy
 * @property \common\models\MantraFunc[] $mantraFuncs
 */
class Func extends \yii\db\ActiveRecord
{
    // use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'createdBy',
            'mantraFuncs'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', ], 'filter', 'filter'=>'\yii\helpers\HtmlPurifier::process'],

            [['name'], 'required'],
            [['created_at'], 'safe'],
            [['created_by'], 'integer'],
            [['name'], 'string', 'max' => 45],

            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'func';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'created_at' => Yii::t('common', 'Created At'),
            'created_by' => Yii::t('common', 'Created By'),
            'createdBy' => Yii::t('common', 'Created By'),
            'mantraFuncs' => '关联文献'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantraFuncs()
    {
        return $this->hasMany(\common\models\MantraFunc::className(), ['func_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * 
     */
    public static function newModel($name){
        $model = new self();
        $model->name = $name;
        if($model->save()){
            return $model;
        }
        return false;
    }

    /**
     * 
     * @param Mantra $ar
     * @param string $attr
     */
    public function saveFuncs($trans, $ar, $attr){
        
    }
    
    /**
     * 
     * @param Mantra $ar
     * @param string $attr
     */
    public function loadFuncs($ar, $attr){
        
    }

    
    /**
     * @param $id
     * @return string
     */
    public static function getName($id)
    {
        $model = self::findOne($id);
        return $model ? $model->name : '';
    }
}
