<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.lapdu".
 *
 * @property integer $id_wilayah
 * @property integer $id_bidang
 * @property integer $id_unit
 * @property string $no_register
 * @property string $tanggal_surat_diterima
 * @property string $nomor_surat_lapdu
 * @property string $perihal_lapdu
 * @property string $tanggal_surat_lapdu
 * @property string $ringkasan_lapdu
 * @property string $file_lapdu
 * @property string $id_media_pelaporan
 * @property string $kepada_lapdu
 * @property string $tembusan_lapdu
 * @property string $keterangan
 * @property string $file_disposisi
 * @property string $tgl_disposisi
 * @property string $status
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property integer $updated_by
 * @property string $updated_ip
 * @property string $updated_time
 *
 * @property MediaPelaporan $idMediaPelaporan
 */
class Lapdu extends \yii\db\ActiveRecord
{
   public $cari;
   public $cmb_bidang,$cari_kejati,$cari_kejari,$cari_cabjari;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.lapdu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register', 'id_media_pelaporan'], 'required'],
            [['created_by', 'updated_by','id_wilayah'], 'integer'],
            [['tanggal_surat_diterima', 'tgl_disposisi', 'created_time', 'updated_time'], 'safe'],
            [['perihal_lapdu', 'tanggal_surat_lapdu', 'ringkasan_lapdu', 'keterangan'], 'string'],
            [['no_register'], 'string', 'max' => 25],
            [['nomor_surat_lapdu', 'file_lapdu', 'kepada_lapdu', 'tembusan_lapdu', 'file_disposisi'], 'string', 'max' => 50],
            [['id_media_pelaporan','id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['status'], 'string', 'max' => 30],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_wilayah' => 'Id Wilayah',
            'id_bidang' => 'Id Bidang',
            'id_unit' => 'Id Unit',
            'no_register' => 'No Register',
            'tanggal_surat_diterima' => 'Tanggal Surat Diterima',
            'nomor_surat_lapdu' => 'Nomor Surat Lapdu',
            'perihal_lapdu' => 'Perihal Lapdu',
            'tanggal_surat_lapdu' => 'Tanggal Surat Lapdu',
            'ringkasan_lapdu' => 'Ringkasan Lapdu',
            'file_lapdu' => 'File Lapdu',
            'id_media_pelaporan' => 'Id Media Pelaporan',
            'kepada_lapdu' => 'Kepada Lapdu',
            'tembusan_lapdu' => 'Tembusan Lapdu',
            'keterangan' => 'Keterangan',
            'file_disposisi' => 'File Disposisi',
            'tgl_disposisi' => 'Tgl Disposisi',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_ip' => 'Updated Ip',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMediaPelaporan()
    {
        return $this->hasOne(MediaPelaporan::className(), ['id_media_pelaporan' => 'id_media_pelaporan']);
    }
}
