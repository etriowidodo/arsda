<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.dugaan_pelanggaran".
 *
 * @property string $id_register
 * @property string $no_register
 * @property string $inst_satkerkd
 * @property integer $wilayah
 * @property integer $inspektur
 * @property string $tgl_dugaan
 * @property integer $sumber_dugaan
 * @property string $perihal
 * @property string $ringkasan
 * @property integer $sumber_pelapor
 * @property integer $status
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $wilayah_laporan
 */
class DugaanPelanggaran extends \yii\db\ActiveRecord {

  public $tgl_lahir;
  public $pendidikan;
  public $agama;
  public $jkl;
  public $wilayah_keterangan;

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'was.dugaan_pelanggaran';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
		[['perihal', 'tgl_surat', 'no_register', 'tgl_dugaan'], 'required'],
        [['wilayah', 'inspektur', 'sumber_dugaan', 'sumber_pelapor', 'status', 'created_by', 'updated_by'], 'integer'],
        [['tgl_dugaan', 'tgl_surat', 'created_time', 'updated_time'], 'safe'],
        [['ringkasan'], 'string'],
        [['status'], 'default', 'value' => 2001],
        [['created_ip', 'updated_ip'], 'required'],
        [['no_register'], 'string', 'max' => 32],
        [['inst_satkerkd'], 'string', 'max' => 10],
        [['perihal', 'upload_file', 'wilayah_laporan'], 'string', 'max' => 200],
        [['flag'], 'string', 'max' => 1],
        [['created_ip', 'updated_ip'], 'string', 'max' => 15]
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
        'id_register' => 'Id Surat',
        'no_register' => 'No Surat',
        'inst_satkerkd' => 'Inst Satkerkd',
        'wilayah' => 'Wilayah',
        'inspektur' => 'Inspektur',
        'tgl_dugaan' => 'Tgl Dugaan',
		'tgl_surat' => 'Tgl Surat',
        'sumber_dugaan' => 'Sumber Dugaan',
        'perihal' => 'Perihal',
        'ringkasan' => 'Ringkasan',
        'sumber_pelapor' => 'Sumber Pelapor',
        'status' => 'Status',
        'upload_file' => 'Upload File',
        'flag' => 'Flag',
        'created_by' => 'Created By',
        'created_ip' => 'Created Ip',
        'created_time' => 'Created Time',
        'updated_ip' => 'Updated Ip',
        'updated_by' => 'Updated By',
        'updated_time' => 'Updated Time',
        'wilayah_laporan' => 'Wilayah Laporan',
    ];
  }

}
