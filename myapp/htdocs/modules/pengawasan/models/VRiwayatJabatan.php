<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
/**
 * This is the model class for table "was.v_riwayat_jabatan".
 *
 * @property integer $id
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nip_baru
 * @property string $peg_nama
 * @property string $jabat_tmt
 * @property string $jabatan
 */
class VRiwayatJabatan extends \yii\db\ActiveRecord
{
    public $id_terlapor;
    public $nama;
    public $id_pemeriksa;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_riwayat_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['jabat_tmt'], 'safe'],
            [['jabatan','gol_pangkat'], 'string'],
            [['peg_nik', 'peg_nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nip_baru' => 'Peg Nip Baru',
            'peg_nama' => 'Peg Nama',
            'jabat_tmt' => 'Jabat Tmt',
            'jabatan' => 'Jabatan',
        ];
    }
    
     public function searchPegawaiWas($params)
    {
        $query = VRiwayatJabatan::find();
        $query->select('*')
                ->from('was.v_riwayat_jabatan');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
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

        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
              ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
              ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
              ->andFilterWhere(['like', 'peg_nama', $this->peg_nama])
          //  ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
            

        return $dataProvider;
    }
    
     public function searchPegawaiTtdWas($peg_nik,$peg_id_jabatan)
    {
        $query =  VRiwayatJabatan::find();
        $query->where("id= :id",[':id' => $peg_id_jabatan ])
              ->andWhere("peg_nik= :pegNik",[':pegNik' => $peg_nik ])
             ->asArray()->one();
       

        return  $query;
        

     
        }
    
         public function searchPemeriksa($id_register)
    {
        $query = static::findBySql("select a.peg_nama, a.peg_nip_baru, a.jabatan from was.v_riwayat_jabatan a
inner join was.pemeriksa b on (a.id=b.id_h_jabatan) where id_register = :id
", [':id' => $id_register ] );
 
         /*       VRiwayatJabatan::find()->from('was.v_riwayat_jabatan a')->innerJoin('was.pemeriksa b', '(a.id=b.id_h_jabatan) ')->where("id_register = :id",[':id' => $id_register ]);*/
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
        ]);

       
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

    
       
            

        return $dataProvider;

     
        }
        
          public function searchTerlapor($id_register)
    {
        $query = static::findBySql("select b.id_terlapor,a.peg_nama, a.peg_nip_baru, a.jabatan from was.v_riwayat_jabatan a
inner join was.terlapor b on (a.id=b.id_h_jabatan) where id_register = :id
", [':id' => $id_register ] );
 
         /*       VRiwayatJabatan::find()->from('was.v_riwayat_jabatan a')->innerJoin('was.pemeriksa b', '(a.id=b.id_h_jabatan) ')->where("id_register = :id",[':id' => $id_register ]);*/
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
        ]);

       
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

    
       
            

        return $dataProvider;

     
        }
        
         public function searchTerlaporQuery($id_register)
    {
        $query = static::findBySql("select b.id_terlapor,a.peg_nama, a.peg_nip_baru, a.jabatan from was.v_riwayat_jabatan a
inner join was.terlapor b on (a.id=b.id_h_jabatan) where id_register = :id
", [':id' => $id_register ] )->asArray()->all();
 
        return $query;

     
        }
        
         public function searchSaksiInternal($id_register)
    {
        $query = static::findBySql("select a.peg_nama, a.peg_nip_baru, a.jabatan  from was.v_riwayat_jabatan a
inner join was.saksi_internal b on (a.id=b.id_h_jabatan)  where id_register = :id
", [':id' => $id_register ] );
 
         /*       VRiwayatJabatan::find()->from('was.v_riwayat_jabatan a')->innerJoin('was.pemeriksa b', '(a.id=b.id_h_jabatan) ')->where("id_register = :id",[':id' => $id_register ]);*/
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
        ]);

       
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

    
       
            

        return $dataProvider;

     
        }
        
          public function searchPemeriksaWas9($id_register)
    {
        $query = static::findBySql("select b.id_pemeriksa, a.peg_nip_baru ||' – '||a.peg_nama as nama from was.v_riwayat_jabatan a inner join was.pemeriksa b on (a.id=b.id_h_jabatan) where id_register = :id", [':id' => $id_register ] )->all();
 
        return $query;

     
        }
        
        
       
}
