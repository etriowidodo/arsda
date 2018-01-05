<?php

namespace app\modules\pdsold\models;

use Yii;

use yii\db\Query;
use app\components\GlobalConstMenuComponent;

/**
 * This is the model class for table "pidum.pdm_ba13".
 *
 * @property string $id_ba13
 * @property string $id_perkara
 * @property string $id_t8
 * @property string $tgl_pembuatan
 * @property string $id_tersangka
 * @property string $no_reg_perkara
 * @property string $no_reg_tahanan
 * @property string $tgl_penahanan
 * @property string $no_sp
 * @property string $tgl_sp
 * @property string $tindakan
 * @property integer $id_ms_loktahanan
 * @property string $tgl_mulai
 * @property string $kepala_rutan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa13 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba13', 'id_perkara'], 'required'],
            [['tgl_pembuatan', 'tgl_penahanan', 'tgl_sp', 'tgl_mulai', 'created_time', 'updated_time'], 'safe'],
            [['id_ms_loktahanan', 'created_by', 'updated_by'], 'integer'],
            [['id_ba13', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['id_t8'], 'string', 'max' => 32],
            [['no_reg_perkara', 'no_reg_tahanan', 'no_sp', 'tindakan', 'kepala_rutan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba13' => 'Id Ba13',
            'id_perkara' => 'Id Perkara',
            'id_t8' => 'Id T8',
            'tgl_pembuatan' => 'Tgl Pembuatan',
            'id_tersangka' => 'Id Tersangka',
            'no_reg_perkara' => 'No Reg Perkara',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'tgl_penahanan' => 'Tgl Penahanan',
            'no_sp' => 'No Sp',
            'tgl_sp' => 'Tgl Sp',
            'tindakan' => 'Tindakan',
            'id_ms_loktahanan' => 'Id Ms Loktahanan',
            'tgl_mulai' => 'Tgl Mulai',
            'kepala_rutan' => 'Kepala Rutan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
    
    public function getTersangka() {
        return $this->hasOne(VwTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }

    public function getLokTahanan() {
        return $this->hasOne(MsLokTahanan::className(), ['id_loktahanan' => 'id_ms_loktahanan']);
    }
	
	public function jaksaPelaksana($id_perkara){
        $query = new Query;
        $query->select("pjs.*")
            ->from('pidum.pdm_jaksa_saksi pjs')
            ->innerJoin('pidum.pdm_p16a p16a', 'pjs.id_perkara = p16a.id_perkara AND pjs.id_table = p16a.id_p16a')
            ->where('pjs.id_perkara=:id_perkara AND p16a.flag<>:flag AND pjs.code_table=:code_table',[':id_perkara'=>$id_perkara,':flag'=>'3',':code_table' => GlobalConstMenuComponent::P16A]);
        $query = $query->createCommand()->queryAll();

        return $query;
    }
}