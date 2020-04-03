<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Mantra;

/**
 * MantraSearch represents the model behind the search form about `common\models\Mantra`.
 */
class MantraSearch extends Mantra
{
    public $func_id = null; //检索用

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sutra_id', 'func_id', 'created_by'], 'integer'],
            [['cd', 'entity_name_han', 'entity_name_sans', 'entity_name_tb', 'text_han', 'text_tb', 'text_sans', 'context', 'cbeta_index', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = Mantra::find()
            ->distinct()
            ->joinWith('mantraFuncs')
            ->joinWith('sutra')
            ->select(['mantra.id', 'mantra.cd', 'mantra.entity_name_han', 'sutra.entity_name_tc sutra_name']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sutra_id' => $this->sutra_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        if($this->func_id){
            $query->andFilterWhere([
                'mantra_func.func_id' => $this->func_id,
            ]);
        }

        $query->andFilterWhere(['like', 'cd', $this->cd])
            ->andFilterWhere(['like', 'entity_name_han', $this->entity_name_han])
            ->andFilterWhere(['like', 'entity_name_tb', $this->entity_name_tb])
            ->andFilterWhere(['like', 'entity_name_sans', $this->entity_name_sans])
            ->andFilterWhere(['like', 'text_han', $this->text_han])
            ->andFilterWhere(['like', 'text_tb', $this->text_tb])
            ->andFilterWhere(['like', 'text_sans', $this->text_sans])
            ->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'cbeta_index', $this->cbeta_index]);

        return $dataProvider;
    }
}
