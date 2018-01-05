<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_berkas".
 *
 * @property string $id_berkas
 * @property string $id_perkara
 * @property string $tgl_terima
 * @property integer $id_statusberkas
 * @property string $flag
 * @property string $no_pengiriman
 * @property string $tgl_pengiriman
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSpdp $idPerkara
 * @property PdmP24[] $pdmP24s
 */
class PdmBerkas extends \app\models\BaseModel
{

    public $wilayah_kerja;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_berkas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_berkas', 'no_pengiriman', 'tgl_pengiriman','tgl_terima'], 'required'],//jaka | tambah tgl berkas dan tgl terima
            [['tgl_terima', 'tgl_pengiriman', 'created_time', 'updated_time', 'tgl_kejadian'], 'safe'],
            [['id_statusberkas', 'created_by', 'updated_by'], 'integer'],
            [['id_berkas'], 'string', 'max' => 16],
            [['id_perkara'], 'string', 'max' => 16],
            [['f111lag'], 'string', 'max' => 1],
            [['no_pengiriman'], 'string', 'max' => 64],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            //[['tgl_terima'], 'unique'],
            //[['tgl_terima'], 'compare','compareAttribute'=>'tgl_pengiriman','operator'=>'>=','message'=>'Tanggal Terima tidak boleh lebih kecil dari Tanggal pengiriman'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_berkas' => 'Id Berkas',
            'id_perkara' => 'Id Perkara',
            'tgl_terima' => 'Tgl Terima',
            'id_statusberkas' => 'Id Statusberkas',
            'flag' => 'Flag',
            'no_pengiriman' => 'Nomor Berkas',//jaka | rubah jadi no berkas
            'tgl_pengiriman' => 'Tanggal Berkas',//jaka | rubah jadi tgl berkas
            'tgl_kejadian' => 'Tgl Kejadian',
            //'tempat_kejadian' => 'Tempat Kejadian',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmP24s()
    {
        return $this->hasMany(PdmP24::className(), ['id_berkas' => 'id_berkas']);
    }
}
