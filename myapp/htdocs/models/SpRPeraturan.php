<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_r_peraturan".
 *
 * @property integer $id
 * @property string $nama_peraturan
 * @property integer $pasal
 * @property string $ayat
 * @property string $huruf
 * @property string $bunyi_peraturan
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpRPeraturan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_r_peraturan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pasal', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['nama_peraturan'], 'string', 'max' => 200],
            [['ayat'], 'string', 'max' => 5],
            [['huruf'], 'string', 'max' => 2],
            [['bunyi_peraturan'], 'string', 'max' => 4000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_peraturan' => 'Nama Peraturan',
            'pasal' => 'Pasal',
            'ayat' => 'Ayat',
            'huruf' => 'Huruf',
            'bunyi_peraturan' => 'Bunyi Peraturan',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
