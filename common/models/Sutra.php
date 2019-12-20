<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "sutra".
 *
 * @property integer $id
 * @property string $cd
 * @property string $entity_name_tc
 * @property string $entity_name_sc
 * @property integer $vol_amount
 * @property integer $vol_amount_actual
 * @property integer $pageno_begin
 * @property integer $pageno_end
 * @property string $memo
 *
 * @property \common\models\Mantra[] $mantras
 */
class Sutra extends \yii\db\ActiveRecord
{
    // use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'mantras'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cd', 'entity_name_tc', 'entity_name_sc', 'memo'], 'filter', 'filter'=>'\yii\helpers\HtmlPurifier::process'],

            [['cd', 'entity_name_tc', 'entity_name_sc'], 'required'],
            [['vol_amount', 'vol_amount_actual', 'pageno_begin', 'pageno_end'], 'integer'],
            [['cd'], 'string', 'max' => 45],
            [['entity_name_tc', 'entity_name_sc'], 'string', 'max' => 100],
            [['memo'], 'string', 'max' => 200],
            [['cd', 'entity_name_tc', 'entity_name_sc'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sutra';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'cd' => '编码',
            'entity_name_tc' => '实体出处名 正体',
            'entity_name_sc' => '实体出处名 简体',
            'vol_amount' => '卷数',
            'vol_amount_actual' => '卷数 实际',
            'pageno_begin' => '开始页码',
            'pageno_end' => '结束页码',
            'memo' => '备注',
            'mantras' => '关联文献'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantras()
    {
        return $this->hasMany(\common\models\Mantra::className(), ['sutra_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * @param $id
     * @return string
     */
    public static function getName($id)
    {
        $model = Sutra::findOne($id);
        return $model ? $model->entity_name_tc : '';
    }
}
