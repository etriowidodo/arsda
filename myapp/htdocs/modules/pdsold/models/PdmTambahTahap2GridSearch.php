<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBerkasTahap1Grid;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "pidum.pdm_berkas_tahap1".
 *
 * @property string $id_berkas
 * @property string $id_perkara
 * @property string $no_berkas
 * @property string $tgl_berkas
 *
 * @property PdmSpdp $idPerkara
 */
class PdmTambahTahap2GridSearch extends  PdmTambahTahap2Grid
{

    public function search($params)
    {
        $query = PdmTambahTahap2Grid::find();
        $this->load($params);

        
            //var_dump($params)."--";echo $this->id_perkara;exit;
            $query->andFilterWhere(['like','upper(no_berkas)',strtoupper($this->id_perkara)])
            ->orFilterWhere(['like','tgl_berkas',strtoupper($this->id_perkara)]);

        

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
