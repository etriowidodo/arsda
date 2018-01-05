<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "simkari.pdm_pasal".
 *
 * @property integer $id
 * @property integer $id_tersangka
 * @property string $pasal
 * @property string $disangkakan
 * @property string $didakwakan
 * @property string $terbukti
 *
 * @property PdmTersangka $idTersangka
 */
class PdmPasal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.pdm_pasal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tersangka'], 'integer'],
            [['pasal'], 'string', 'max' => 500],
            [['disangkakan', 'didakwakan', 'terbukti'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tersangka' => 'Id Tersangka',
            'pasal' => 'Pasal',
            'disangkakan' => 'Disangkakan',
            'didakwakan' => 'Didakwakan',
            'terbukti' => 'Terbukti',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTersangka()
    {
        return $this->hasOne(PdmTersangka::className(), ['id' => 'id_tersangka']);
    }
}
