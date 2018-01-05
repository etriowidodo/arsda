<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_nota_pendapat_t4_jaksa".
 *
 * @property string $id_perpanjangan
 * @property integer $id_nota_pendapat
 * @property integer $id_jaksa
 * @property string $nip_jaksa_p16
 * @property string $nama_jaksa_p16
 * @property string $jabatan_jaksa_p16
 * @property string $pangkat_jaksa_p16
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmNotaPendapatT4 $idPerpanjangan
 */
class PdmNotaPendapatT4Jaksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_nota_pendapat_t4_jaksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perpanjangan', 'id_nota_pendapat', 'id_jaksa', 'created_by', 'updated_by'], 'required'],
            [['id_nota_pendapat', 'id_jaksa', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_perpanjangan'], 'string', 'max' => 121],
            [['nip_jaksa_p16'], 'string', 'max' => 20],
            [['nama_jaksa_p16'], 'string', 'max' => 128],
            [['jabatan_jaksa_p16'], 'string', 'max' => 200],
            [['pangkat_jaksa_p16'], 'string', 'max' => 256],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perpanjangan' => 'Id Perpanjangan',
            'id_nota_pendapat' => 'Id Nota Pendapat',
            'id_jaksa' => 'Id Jaksa',
            'nip_jaksa_p16' => 'Nip Jaksa P16',
            'nama_jaksa_p16' => 'Nama Jaksa P16',
            'jabatan_jaksa_p16' => 'Jabatan Jaksa P16',
            'pangkat_jaksa_p16' => 'Pangkat Jaksa P16',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
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
    public function getIdPerpanjangan()
    {
        return $this->hasOne(PdmNotaPendapatT4::className(), ['id_perpanjangan' => 'id_perpanjangan', 'id_nota_pendapat' => 'id_nota_pendapat']);
    }
}
