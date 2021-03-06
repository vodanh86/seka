<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
	public $created_normal;
	public $updated_normal;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'brand_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'created_normal', 'updated_normal'], 'safe'],
            [['price'], 'number'],
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
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->asArray(),
			'pagination' => [
			    'pageSize' => 15,
			]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);
	    
	if($this->created_normal)
	        $query->andFilterWhere(['between', 'created_at', strtotime($this->created_normal), strtotime($this->created_normal)+86400]);
	if($this->updated_normal)
		$query->andFilterWhere(['between', 'updated_at', strtotime($this->updated_normal), strtotime($this->updated_normal)+86400]);

        return $dataProvider;
    }
}
