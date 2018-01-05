<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_pengembalian_berkas".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_pengembalian
 * @property string $tembusan
 *
 * @property PdmPengembalianBerkas $idPengembalian
 */
class PdmTembusanPengembalianBerkas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_pengembalian_berkas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 126],
            [['id_pengembalian'], 'string', 'max' => 121],
            [['tembusan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan' => 'Id Tembusan',
            'no_urut' => 'No Urut',
            'id_pengembalian' => 'Id Pengembalian',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPengembalian()
    {
        return $this->hasOne(PdmPengembalianBerkas::className(), ['id_pengembalian' => 'id_pengembalian']);
    }
}
