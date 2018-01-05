<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_nota_pendapat_t4".
 *
 * @property string $id_perpanjangan
 * @property integer $id_nota_pendapat
 * @property string $tgl_nota
 * @property integer $persetujuan
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
 * @property PdmPerpanjanganTahanan $idPerpanjangan
 * @property PdmNotaPendapatT4Jaksa[] $pdmNotaPendapatT4Jaksas
 */
class PdmNotaPendapatT4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_nota_pendapat_t4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perpanjangan', 'id_nota_pendapat', 'created_by', 'updated_by'], 'required'],
            [['id_nota_pendapat', 'persetujuan', 'created_by', 'updated_by'], 'integer'],
            [['tgl_nota', 'created_time', 'updated_time','tgl_awal_penahanan_oleh_penyidik','tgl_akhir_penahanan_oleh_penyidik','tgl_awal_permintaan_perpanjangan','tgl_akhir_permintaan_perpanjangan'], 'safe'],
            [['id_perpanjangan','id_perkara','kota'], 'string', 'max' => 121],
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
            'tgl_nota' => 'Tgl Nota',
            'persetujuan' => 'Persetujuan',
            'id_perkara' => 'Id Perkara',
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
        return $this->hasOne(PdmPerpanjanganTahanan::className(), ['id_perpanjangan' => 'id_perpanjangan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmNotaPendapatT4Jaksas()
    {
        return $this->hasMany(PdmNotaPendapatT4Jaksa::className(), ['id_perpanjangan' => 'id_perpanjangan', 'id_nota_pendapat' => 'id_nota_pendapat']);
    }
}
