<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "pidum.pdm_pengantar_tahap1".
 *
 * @property string $id_pengantar
 * @property string $id_berkas
 * @property string $no_pengantar
 * @property string $tgl_pengantar
 * @property string $tgl_terima
 *
 * @property PdmBerkas $idBerkas
 * @property PdmUuPasalTahap1[] $pdmUuPasalTahap1s
 */
class PdmPengantarTahap1 extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pengantar_tahap1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pengantar', 'id_berkas', 'no_pengantar','tgl_pengantar', 'tgl_terima'], 'required'],
            [['tgl_pengantar', 'tgl_terima'], 'safe'],
            [['id_berkas'], 'string', 'max' => 70],
            [['id_pengantar'], 'string', 'max' => 135],
            [['no_pengantar'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pengantar' => 'ID pengantar',
            'id_berkas' => 'ID berkas',
            'no_pengantar' => 'Nomor pengantar',
            'tgl_pengantar' => 'Tanggal pengantar',
            'tgl_terima' => 'Tanggal terima',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBerkas()
    {
        return $this->hasOne(PdmBerkasTahap1::className(), ['id_berkas' => 'id_berkas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmUuPasalTahap1s()
    {
        return $this->hasMany(PdmUuPasalTahap1::className(), ['id_pengantar' => 'id_pengantar']);
    }
    }
  

