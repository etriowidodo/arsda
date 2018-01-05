<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmSysMenu;
use yii\db\Query;
/**
 * PdmSysMenuSearch represents the model behind the search form about `app\modules\pidum\models\PdmSysMenu`.
 */
class PdmSysMenuSearch extends PdmSysMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'durasi', 'id__group_perkara', 'id_menu', 'is_show'], 'integer'],
            [['kd_berkas', 'no_urut', 'keterangan', 'url', 'flag', 'akronim', 'no_surat', 'file_name', 'is_path'], 'safe'],
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
      $query = PdmSysMenu::find();
		//$query = new Query;
		//$query->select('*')
       //         ->from('pidum.pdm_sys_menu');
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
            'durasi' => $this->durasi,
            'id__group_perkara' => $this->id__group_perkara,
            'id_menu' => $this->id_menu,
            'is_show' => $this->is_show,
        ]);

        $query->andFilterWhere(['like', 'upper(kd_berkas)', strtoupper($this->kd_berkas)])
            ->andFilterWhere(['like', 'no_urut', $this->no_urut])
            ->andFilterWhere(['like', 'upper(keterangan)',strtoupper($this->keterangan)])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'akronim', $this->akronim])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'is_path', $this->is_path]);

        return $dataProvider;
    }
}
