<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_pasal".
 *
 * @property string $id_pasal
 * @property string $id_perkara
 * @property integer $id_jns_pasal
 * @property string $undang
 * @property string $pasal
 * @property string $parent
 * @property string $child
 * @property string $flag
 *
 * @property PdmSpdp $idPerkara
 */
class PdmPasal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pasal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pasal'], 'required'],
            [['id_jns_pasal'], 'integer'],
            [['id_pasal'], 'string', 'max' => 16],
            [['id_perkara'], 'string', 'max' => 56],
            [['undang', 'pasal'], 'string', 'max' => 128],
            [['parent'], 'string', 'max' => 10],
            [['child'], 'string', 'max' => 12],
            [['flag'], 'string', 'max' => 1],
            [['id_pasal'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pasal' => 'Id Pasal',
            'id_perkara' => 'Id Perkara',
            'id_jns_pasal' => 'Id Jns Pasal',
            'undang' => 'Undang',
            'pasal' => 'Pasal',
            'parent' => 'Parent',
            'child' => 'Child',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
