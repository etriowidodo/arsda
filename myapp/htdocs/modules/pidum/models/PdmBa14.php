<?php

namespace app\modules\pidum\models;
use Yii;
use yii\db\Query;
use app\components\GlobalConstMenuComponent;

/**
 * This is the model class for table "pidum.pdm_ba14".
 *
 * @property string $id_ba14
 * @property string $id_t8
 * @property string $tgl_pembuatan
 * @property string $id_tersangka
 * @property string $no_reg_perkara
 * @property string $no_reg_tahanan
 * @property string $tgl_mulai_tahan
 * @property string $no_sp_kepala
 * @property string $tgl_sp_kejaksaan
 * @property string $tindakan
 * @property integer $id_ms_loktahanan
 * @property string $tgl_mulai
 * @property string $kepala_rutan
 * @property string $id_perkara
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmBa14 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba14';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba14', 'tgl_pembuatan', 'tindakan', 'id_perkara'], 'required'],
            [['tgl_pembuatan', 'tgl_mulai_tahan', 'tgl_sp_kejaksaan', 'tgl_mulai', 'created_time', 'updated_time'], 'safe'],
            [['id_ms_loktahanan', 'created_by', 'updated_by'], 'integer'],
            [['id_ba14', 'id_perkara'], 'string', 'max' => 16],
            [['id_t8', 'id_tersangka', 'no_reg_perkara', 'no_reg_tahanan', 'no_sp_kepala', 'tindakan', 'kepala_rutan'], 'string', 'max' => 32],
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
            'id_ba14' => 'Id Ba14',
            'id_t8' => 'Id T8',
            'tgl_pembuatan' => 'Tgl Pembuatan',
            'id_tersangka' => 'Id Tersangka',
            'no_reg_perkara' => 'No Reg Perkara',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'tgl_mulai_tahan' => 'Tgl Mulai Tahan',
            'no_sp_kepala' => 'No Sp Kepala',
            'tgl_sp_kejaksaan' => 'Tgl Sp Kejaksaan',
            'tindakan' => 'Tindakan',
            'id_ms_loktahanan' => 'Id Ms Loktahanan',
            'tgl_mulai' => 'Tgl Mulai',
            'kepala_rutan' => 'Kepala Rutan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
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
