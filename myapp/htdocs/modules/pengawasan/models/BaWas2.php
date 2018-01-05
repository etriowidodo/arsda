<?php

namespace app\modules\pengawasan\models;

use Yii;


class BaWas2 extends \yii\db\ActiveRecord
{

	public $cari;
	//public $no_register;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl','tanggal_spwas', 'created_time', 'updated_time'], 'safe'],
            [['id_ba_was2','id_sp_was','created_by', 'updated_by'], 'integer'],
            [['hari'], 'string', 'max' => 10],
            [['no_register'], 'string', 'max' => 25],
            [['tempat'], 'string', 'max' => 60],
            [['tempat'], 'string', 'max' => 60],
            [['nomor_sp_was','nama_penandatangan'], 'string', 'max' => 100],
            [['upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['pangkat_penandatangan'], 'string', 'max' => 30],
            [['golongan_penandatangan'], 'string', 'max' => 50],
            [['nip_penandatangan'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was2' => 'Id Ba Was 2',
            
        ];
    }
}
