<?php

namespace app\models;

use Yii;
use app\models\KpInstSatker;
use yii\base\Model;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;

/**
 * KpInstSatkerSearch represents the model behind the search form about `app\models\KpInstSatker`.
 */
class KpInstSatkerSearch extends KpInstSatker {

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
         [['inst_satkerkd', 'inst_nama'], 'safe'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function scenarios() {
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
  public function search($params) {
	  
    $query = KpInstSatker::find(['is_active'=>'1'])
			->orderBy(['inst_satkerkd'=>SORT_ASC]);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
		 'pagination' => [
            'pageSize' => 5,
        ],
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }
	
	if($params['KpInstSatkerSearch']['inst_satkerkd']!=''){
		$query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd]);
	}
    if($params['KpInstSatkerSearch']['inst_nama']!=''){
		
		$query->andFilterWhere(['like', 'upper(inst_nama)', strtoupper($params['KpInstSatkerSearch']['inst_nama'])]);
	}

    return $dataProvider;
  }

  public function searchSatker($params) {
    $satker='00';
    $config = \app\modules\pidum\models\PdmConfig::find()->one();
    $satker=$config->kd_satker;

    if ($satker == '00') {
      $query = KpInstSatker::find()
              ->select(['inst_satkerkd', 'inst_nama'])
              ->where(['length(inst_satkerkd)' => 2, 'is_active' => '1'])
              ->orderBy('inst_satkerkd');
    } else {
      $query = KpInstSatker::find()
              ->select(['inst_satkerkd', 'inst_nama'])
              ->where('inst_satkerkd like :satker', array(':satker' => $satker . '%'))
              ->andWhere(['is_active' => '1'])
              ->orderBy('inst_satkerkd');
    }


    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }



    $query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);

    return $dataProvider;
  }

  public function searchKodeSatker($kd, $params) {
    if ($kd != "00") {
      $query = KpInstSatker::find()
              ->select('*')
              ->where("inst_satkerkd LIKE '$kd%'")
              ->orderBy('inst_satkerkd asc');
    } else {
      $query = KpInstSatker::find()
              ->select('*')
              ->orderBy('inst_satkerkd asc');
    }


    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }



    $query->andFilterWhere(['like', 'lower(inst_lokinst)', strtolower($this->inst_lokinst)]);
    $query->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);

    return $dataProvider;
  }

}
