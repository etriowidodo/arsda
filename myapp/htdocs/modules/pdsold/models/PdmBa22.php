<?php

namespace app\modules\pdsold\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pidum.pdm_ba22".
 *
 * @property string $id_ba22
 * @property string $id_perkara
 * @property integer $id_msstatdata
 * @property string $tgl_surat
 * @property string $lokasi
 * @property string $nip1
 * @property string $nama1
 * @property string $pangkat1
 * @property string $jabatan1
 * @property string $nip2
 * @property string $nama2
 * @property string $pangkat2
 * @property string $jabatan2
 * @property string $keperluan
 * @property string $dimusnahkan
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
class PdmBa22 extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public $wilayah;

    public static function tableName() {
        return 'pidum.pdm_ba22';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_ba22'], 'required'],
            [['id_msstatdata', 'created_by', 'updated_by'], 'integer'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['id_ba22', 'id_perkara'], 'string', 'max' => 16],
            [['lokasi', 'nama1', 'pangkat1', 'nama2', 'pangkat2'], 'string', 'max' => 64],
            [['nip1', 'nip2'], 'string', 'max' => 20],
            [['jabatan1', 'jabatan2', 'keperluan', 'dimusnahkan'], 'string', 'max' => 256],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_ba22' => 'Id Ba22',
            'id_perkara' => 'Id Perkara',
            'id_msstatdata' => 'Id Msstatdata',
            'tgl_surat' => 'Tgl Surat',
            'lokasi' => 'Lokasi',
            'nip1' => 'Nip1',
            'nama1' => 'Nama1',
            'pangkat1' => 'Pangkat1',
            'jabatan1' => 'Jabatan1',
            'nip2' => 'Nip2',
            'nama2' => 'Nama2',
            'pangkat2' => 'Pangkat2',
            'jabatan2' => 'Jabatan2',
            'keperluan' => 'Keperluan',
            'dimusnahkan' => 'Dimusnahkan',
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
     * @return ActiveQuery
     */
    public function getIdPerkara() {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }

}
