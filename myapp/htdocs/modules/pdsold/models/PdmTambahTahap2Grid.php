<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "pidum.pdm_berkas_tahap1".
 *
 * @property string $id_berkas
 * @property string $id_perkara
 * @property string $no_berkas
 * @property string $tgl_berkas
 *
 * @property PdmSpdp $idPerkara
 */
class   PdmTambahTahap2Grid extends  ActiveRecord
{
    /**
     * @inheritdoc
     */
     
    public static function tableName()
    {
        return 'pidum.vw_gridberkastahap2';
    }

    /**
     * @inheritdoc
     */


    /*public function rules()
    {
        return [
            [['id_berkas', 'no_berkas'], 'required'],
            [['tgl_berkas'], 'safe'],
            [['id_berkas'], 'string', 'max' => 70],
            [['no_berkas'], 'string', 'max' => 64],
            [['id_perkara'], 'string', 'max' => 56],
            ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_berkas' => 'Id Berkas',
            'id_perkara' => 'Id Perkara',
            'no_berkas' => 'No Berkas',
            'tgl_berkas' => 'Tgl Berkas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }*/
}
