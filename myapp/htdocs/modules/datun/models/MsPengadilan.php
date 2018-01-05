<?php

namespace app\modules\datun\models;

use Yii;

/**
 * This is the model class for table "datun.pengadilan_tk_1".
 *
 * @property string $kode
 * @property string $deskripsi
 */
 
class MsPengadilan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'datun.master_pengadilan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode'], 'required'],
            [['kode'], 'string', 'max' => 2],
            [['deskripsi'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'deskripsi' => 'Deskripsi',
        ];
    }

    /**
     * @inheritdoc
     * @return MsInstPenyidikQuery the active query used by this AR class.
     */
 
	/*faiz jkt*/
	function msimpan($post){
		$connection = Yii::$app->db;
		$kdpt  	= htmlspecialchars($post['kdpt'], ENT_QUOTES);
        $kdpn  	= htmlspecialchars($post['kdpn'], ENT_QUOTES);
        $desk  	= htmlspecialchars($post['desk'], ENT_QUOTES);
		$sts  	= htmlspecialchars($post['sts'], ENT_QUOTES);
		
		if($sts=='tk2'){
		$sql="insert into datun.pengadilan_negeri values('2','$kdpt','$kdpn','$desk')";
		}else{
		$sql="insert into datun.pengadilan_tinggi values('$kdpt','1','$desk')";
		}
		$command = $connection->createCommand($sql);
		$mpengadilan = $command->execute();	
	 }
 
}
