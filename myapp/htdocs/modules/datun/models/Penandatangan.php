<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * Menu represents the model behind the search form about [[\mdm\admin\models\Menu]].
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Penandatangan extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'datun.m_penandatangan';
    }

    /**
     * @inheritdoc
     */
	 //bowo 30 mei 2016 #menambahkan field peg_nip_baru
    public function rules()
    {
        return [
            [['peg_nik', 'nama', 'pangkat', 'jabatan', 'keterangan', 'peg_nip_baru'], 'required'],
            [['peg_nik','peg_nip_baru'], 'string', 'max' => 20],
            [['nama', 'jabatan', 'keterangan'], 'string', 'max' => 128],
            [['pangkat'], 'string', 'max' => 64],
            [['is_active', 'flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nik' => 'Peg Nik',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'keterangan' => 'Keterangan',
            'is_active' => 'Is Active',
            'flag' => 'Flag',
			'peg_nip_baru' => 'NIP',
        ];
    }

    public function searchCustom($get)
    {
		$q1  = htmlspecialchars($get['q1'], ENT_QUOTES);
		$sql = "select * from datun.m_penandatangan where 1=1";
		
		if($q1)
			$sql .= " and (upper(kode) like '%".strtoupper($q1)."%' or upper(deskripsi) like '%".strtoupper($q1)."%')";

		$kueri = $this->db->createCommand("SELECT COUNT(*) FROM (".$sql.") a");
		$count = $kueri->queryScalar();
		$sql .= " order by kode";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
			'totalCount' => $count,
			'pagination' => ['pageSize' => 20],
        ]);

        return $dataProvider;
    }

    public function cekRole($post){
		$q1		= htmlspecialchars($post['q1'], ENT_QUOTES);
		$isNew 	= htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$sql   	= "select count(*) from datun.m_penandatangan where kode = :kode and kode_tk = :kode_tk";
		$kueri 	= $this->db->createCommand($sql)->bindValues([':kode'=>$q1, ':kode_tk'=>Yii::$app->user->identity->kode_tk]);
		$count 	= ($isNew)?$kueri->queryScalar():0;
		return $count;
    }

    public function simpanData($post){
		$connection = $this->db;
		$kodetk_ttd = Yii::$app->user->identity->kode_tk;
		$kode_ttd 	= htmlspecialchars($post['kd_ttd'], ENT_QUOTES);
		$desc_ttd 	= htmlspecialchars($post['deskripsi'], ENT_QUOTES);

		$isNewRecord = htmlspecialchars($post['isNewRecord'], ENT_QUOTES);
		$transaction = $connection->beginTransaction();
		try {
			if($isNewRecord){
				$sql1 = "insert into datun.m_penandatangan(kode_tk, kode, deskripsi) values('".$kodetk_ttd."', '".$kode_ttd."', '".$desc_ttd."')";
			}else{
				$sql1 = "update datun.m_penandatangan set deskripsi = '".$desc_ttd."' where kode = '".$kode_ttd."'";
			}
			$connection->createCommand($sql1)->execute();
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }

    public function hapusData($post){
		$connection = $this->db;
		$transaction = $connection->beginTransaction();
		try {
			if(count($post['id']) > 0){
				foreach($post['id'] as $idx=>$val){
					$sql1 = "delete from datun.m_penandatangan where kode = '".$val."'";
					$connection->createCommand($sql1)->execute();
				}
			}
			$transaction->commit();
			return true;
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}
    }
}
