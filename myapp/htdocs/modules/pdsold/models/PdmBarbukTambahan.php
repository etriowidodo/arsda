<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_barbuk_tambahan".
 *
 * @property string $id
 * @property string $id_b4
 * @property string $nama
 * @property string $jumlah
 * @property integer $id_satuan
 * @property string $sita_dari
 * @property string $tindakan
 * @property integer $id_stat_kondisi
 * @property string $id_perkara
 * @property string $tgl_eksekusi
 * @property integer $id_ms_barbuk_eksekusi
 * @property integer $is_lelang
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmB4 $idB4
 * @property PdmMsSatuan $idSatuan
 */
class PdmBarbukTambahan extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_barbuk_tambahan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_b4', 'nama', 'jumlah', 'sita_dari', 'tindakan'], 'required'],
            [['jumlah'], 'number'],
            [['id_satuan', 'id_stat_kondisi', 'id_ms_barbuk_eksekusi', 'is_lelang', 'created_by', 'updated_by'], 'integer'],
            [['tgl_eksekusi', 'created_time', 'updated_time'], 'safe'],
            [['id', 'id_b4'], 'string', 'max' => 20],
            [['nama', 'sita_dari', 'tindakan'], 'string', 'max' => 128],
            [['id_perkara'], 'string', 'max' => 16],
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
            'id' => 'ID',
            'id_b4' => 'Id B4',
            'nama' => 'Nama',
            'jumlah' => 'Jumlah',
            'id_satuan' => 'Id Satuan',
            'sita_dari' => 'Sita Dari',
            'tindakan' => 'Tindakan',
            'id_stat_kondisi' => 'Id Stat Kondisi',
            'id_perkara' => 'Id Perkara',
            'tgl_eksekusi' => 'Tgl Eksekusi',
            'id_ms_barbuk_eksekusi' => 'Id Ms Barbuk Eksekusi',
            'is_lelang' => 'Is Lelang',
            'flag' => 'Flag',
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
    public function getIdB4()
    {
        return $this->hasOne(PdmB4::className(), ['id_b4' => 'id_b4']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSatuan()
    {
        return $this->hasOne(PdmMsSatuan::className(), ['id' => 'id_satuan']);
    }
}
