<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the base model class for table "mantra".
 *
 * @property integer $id
 * @property string $cd
 * @property string $entity_name_han 文献名汉文
 * @property string $entity_name_tb 文献名藏文
 * @property string $entity_name_sans 文献名梵文
 * @property string $text_han 文献汉文
 * @property string $text_tb 文献藏文
 * @property string $text_sans 文献梵文
 * @property int $sutra_id
 * @property string $context
 * @property string $cbeta_index
 * @property string $created_at
 * @property integer $created_by
 * @property string  $voice_base_url
 * @property string  $voice_path
 *
 * @property \common\models\User $createdBy
 * @property \common\models\MantraFunc[] $mantraFuncs
 * @property \common\models\Sutra $sutra
 */
class Mantra extends \yii\db\ActiveRecord
{
    // use \mootensai\relation\RelationTrait;

    public $funcs = [];

    /**
     * @var array
     */
    public $voice;

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'createdBy',
            'mantraFuncs',
            'sutra'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_name_han', 'entity_name_tb', 'entity_name_sans', 'text_sans', 'text_han', 'text_tb', 'context', 'cbeta_index'], 'filter', 'filter'=>'\yii\helpers\HtmlPurifier::process'],

            [['entity_name_han', 'text_han', 'context', 'sutra_id', 'funcs'], 'required'],
            [['text_han', 'text_tb', 'text_sans', 'context'], 'string'],
            [['created_at', 'funcs', 'voice'], 'safe'],
            [['created_by'], 'integer'],
            [['cd'], 'string', 'max' => 45],
            [['entity_name_han', 'entity_name_tb', 'entity_name_sans', 'cbeta_index'], 'string', 'max' => 100],
            [['voice_base_url', 'voice_path'], 'string', 'max' => 255],
            [['cd', 'entity_name_han'], 'unique'],

            [['sutra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sutra::className(), 'targetAttribute' => ['sutra_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mantra';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'cd' => '文献编号',
            'entity_name_han' => '文献名汉文',
            'entity_name_tb' => '文献名藏文',
            'entity_name_sans' => '文献名梵文',
            'text_han' => '文献汉文',
            'text_tb' => '文献藏文',
            'text_sans' => '文献梵文',
            'context' => '前后文',
            'cbeta_index' => 'CBETA',
            'sutra_id' => '出处',
            'created_at' => Yii::t('common', 'Created At'),
            'created_by' => Yii::t('common', 'Created By'),
            'createdBy' => '创建者',
            'mantraFuncs' => '标签',
            'funcs' => '标签',
            'func_id' => '标签',
            'voice' => '录音',
        ];
    }

    public function getFuncs(){
        if(empty($this->funcs)){
            $this->loadFuncs();
        }

        return $this->funcs;
    }

    public function getFuncsText(){
        if(empty($this->funcs)){
            $this->loadFuncs();
        }

        return implode(', ', $this->funcs);
    }

    public function loadFuncs(){
        foreach($this->mantraFuncs as $mf){
            $this->funcs[] = $mf->func->name;
        }
    }

    public function saveFuncs(){
        if(empty($this->funcs)){
            return ;
        }

        foreach($this->mantraFuncs as $mf){
            $mf->delete();
        }

        foreach($this->funcs as $func){
            $func = \yii\helpers\HtmlPurifier::process($func);
            $fmodel = Func::findOne(['name' => $func]);
            if(empty($fmodel)){
                $fmodel = Func::newModel($func);
            }

            MantraFunc::newModel($this, $fmodel); //$this->id be careful
        }
    }

    /**
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterSave()
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveFuncs();
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
    public function getSutra()
    {
        return $this->hasOne(\common\models\Sutra::className(), ['id' => 'sutra_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMantraFuncs()
    {
        return $this->hasMany(\common\models\MantraFunc::className(), ['mantra_id' => 'id']);
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
            [
                'class' => UploadBehavior::class,
                'attribute' => 'voice',
                'pathAttribute' => 'voice_path',
                'baseUrlAttribute' => 'voice_base_url',
            ],
        ];
    }
}
