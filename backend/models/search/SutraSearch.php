<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Sutra;

/**
 * SutraSearch represents the model behind the search form about `common\models\Sutra`.
 */
class SutraSearch extends Sutra
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vol_amount', 'vol_amount_actual', 'pageno_begin', 'pageno_end'], 'integer'],
            [['cd', 'entity_name_tc', 'entity_name_sc', 'memo'], 'safe'],
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
        $query = Sutra::find();

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
            'vol_amount' => $this->vol_amount,
            'vol_amount_actual' => $this->vol_amount_actual,
            'pageno_begin' => $this->pageno_begin,
            'pageno_end' => $this->pageno_end,
        ]);

        $query->andFilterWhere(['like', 'cd', $this->cd])
            ->andFilterWhere(['like', 'entity_name_tc', $this->entity_name_tc])
            ->andFilterWhere(['like', 'entity_name_sc', $this->entity_name_sc])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}
