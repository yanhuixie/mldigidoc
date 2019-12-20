<?php

namespace common\models;

use Yii;

/**
 * This is the base model class for table "mantra_func".
 *
 * @property integer $id
 * @property integer $mantra_id
 * @property integer $func_id
 *
 * @property \common\models\Mantra $mantra
 * @property \common\models\Func $func
 */
class MantraFunc extends \yii\db\ActiveRecord
{
    // use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'mantra',
            'func'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mantra_id', 'func_id'], 'required'],
            [['mantra_id', 'func_id'], 'integer'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mantra_func';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'mantra_id' => '文献',
            'func_id' => '标签',
            
        ];
    }

    /**
     * 
     */
    public static function newModel($mantra, $func){
        $model = new self();
        $model->mantra_id = $mantra->id;
        $model->func_id = $func->id;
        if($model->save()){
            return $model;
        }
        return false;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantra()
    {
        return $this->hasOne(\common\models\Mantra::className(), ['id' => 'mantra_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunc()
    {
        return $this->hasOne(\common\models\Func::className(), ['id' => 'func_id']);
    }
    }
