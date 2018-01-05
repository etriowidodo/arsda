<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_pendapat_p24".
 *
 * @property string $id
 * @property string $isi_pendapat
 */
class MsPendapatP24 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_pendapat_p24';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isi_pendapat'], 'required'],
            [['id'], 'string', 'max' => 1],
            [['isi_pendapat'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isi_pendapat' => 'Isi Pendapat',
        ];
    }

    /**
     * @inheritdoc
     * @return MsPendapatP24Query the active query used by this AR class.
     */

}
