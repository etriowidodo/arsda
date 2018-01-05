<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_detail_b10".
 *
 * @property string $id_dtb10
 * @property string $id_perkara
 * @property string $id_b10
 * @property string $id_barbuk
 * @property string $tgl_terima
 * @property string $tgl_limpah
 * @property string $diktum
 * @property string $no_putus
 * @property string $tgl_putus
 * @property string $amar_putus
 * @property string $plt_putus
 * @property string $tgl_plt_putus
 * @property string $keterangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSpdp $idPerkara
 */
class PdmDetailB10 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_detail_b10';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dtb10'], 'required'],
            [['tgl_terima', 'tgl_limpah', 'tgl_putus', 'tgl_plt_putus', 'created_time', 'updated_time'], 'safe'],
            [['amar_putus', 'keterangan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_dtb10', 'id_perkara', 'id_b10', 'id_barbuk'], 'string', 'max' => 16],
            [['diktum'], 'string', 'max' => 128],
            [['no_putus', 'plt_putus'], 'string', 'max' => 64],
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
            'id_dtb10' => 'Id Dtb10',
            'id_perkara' => 'Id Perkara',
            'id_b10' => 'Id B10',
            'id_barbuk' => 'Id Barbuk',
            'tgl_terima' => 'Tgl Terima',
            'tgl_limpah' => 'Tgl Limpah',
            'diktum' => 'Diktum',
            'no_putus' => 'No Putus',
            'tgl_putus' => 'Tgl Putus',
            'amar_putus' => 'Amar Putus',
            'plt_putus' => 'Plt Putus',
            'tgl_plt_putus' => 'Tgl Plt Putus',
            'keterangan' => 'Keterangan',
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
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }

    public function getBarbuk()
    {
        return $this->hasOne(PdmBarbukTambahan::className(), ['id' => 'id_barbuk']);
    }
}
