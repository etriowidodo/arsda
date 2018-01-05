<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\modules\pidum\models\VwGridPenuntutan;


/**
 * VwGridPrapenuntutanSearch represents the model behind the search form about `app\modules\pidum\models\VwGridPrapenuntutan`.
 */
class VwGridPenuntutanSearch extends VwGridPenuntutan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perkara', 'no_surat', 'tgl_surat', 'assurat', 'tgl_terima', 'no_p16a', 'tgl_p16a', 'jpu', 'tersangka', 'id_sys_menu', 'url'], 'safe'],
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
	/* 
    public function search($params)
    {
        $query = VwGridPrapenuntutan::find();

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
            'tgl_surat' => $this->tgl_surat,
            'tgl_terima' => $this->tgl_terima,
            'tgl_p16a' => $this->tgl_p16a,
        ]);

        $query->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'assurat', $this->assurat])
            ->andFilterWhere(['like', 'no_p16', $this->no_p16])
            ->andFilterWhere(['like', 'jpu', $this->jpu])
            ->andFilterWhere(['like', 'tersangka', $this->tersangka])
            ->andFilterWhere(['like', 'id_sys_menu', $this->id_sys_menu])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
	*/
	
	
	 public function search($params)
    {
        $query = new Query;
        $query->select('*')
                ->from('pidum.vw_grid_penuntutan');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

     /*   $query->andFilterWhere([
            'id' => $this->id,
            
        ]);*/
		
	if(!empty($this->id_perkara)){
                $query->andFilterWhere([
                        'or',
                        ['like', 'no_surat', $this->id_perkara],
                        ['like', 'id_perkara', $this->id_perkara],
                        ['=', 'date(tgl_surat)', date('Y-m-d', strtotime($this->id_perkara)) ],
                        ['like','assurat', $this->id_perkara],
                        ['like','upper(tersangka)',strtoupper($this->id_perkara)],
                        ['like','upper(status)',strtoupper($this->id_perkara)],
                        ['like','upper(undang)',strtoupper($this->id_perkara)],
                ]);
        }

        return $dataProvider;
    }
}
