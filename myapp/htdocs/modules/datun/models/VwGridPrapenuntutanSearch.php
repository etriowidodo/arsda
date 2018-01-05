<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\datun\models\VwGridPrapenuntutan;

/**
 * VwGridPrapenuntutanSearch represents the model behind the search form about `app\modules\pidum\models\VwGridPrapenuntutan`.
 */
class VwGridPrapenuntutanSearch extends VwGridPrapenuntutan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'no_surat', 'tgl_surat', 'assurat', 'tgl_terima', 'no_p16', 'tgl_p16', 'jpu', 'tersangka', 'id_sys_menu', 'data_berkas'], 'safe'],
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
        $query = VwGridPrapenuntutan::find();

       

        $this->load($params);
		

       

        $query->andFilterWhere([
            'tgl_surat' => $this->tgl_surat,
            'tgl_terima' => $this->tgl_terima,
            'tgl_p16' => $this->tgl_p16,
        ]);
		if(!empty($params) && $this->id_perkara !=''){
			//var_dump($params)."--";echo $this->id_perkara;exit;
			$query->andFilterWhere(['like','upper(status)',strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like', 'upper(no_surat)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(assurat)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(jpu)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(no_p16)', strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(tersangka)',strtoupper($this->id_perkara)])
			      ->orFilterWhere(['like','upper(undang_pasal)',strtoupper($this->id_perkara)]);
			if(count(explode('-',$this->id_perkara)) == 3){
			      $query->orFilterWhere(['=', 'tgl_surat', $this->id_perkara ]);
			      $query->orFilterWhere(['=', 'tgl_terima', $this->id_perkara ]);
			      $query->orFilterWhere(['=', 'tgl_p16', $this->id_perkara ]);
			      $query->orFilterWhere(['like', 'data_berkas', $this->id_perkara ]);
			}
			
		}
		
		 $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		 if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
