<?php

/*use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
//require('..\modules\pidsus\controllers\viewFormFunction.php');
//$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */
/*$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$typeSurat."') order by id_penandatangan";
$sqlJenisKasus="select id_detail, nama_detail from pidsus.parameter_detail where id_header=9";
*/

$this->title = 'Laporan Penerimaan SPDP';
$this->params['idtitle']=$_SESSION['noSpdpDik'];
//$_SESSION['idPdsDik']="1312";
//echo $_SESSION['idPdsDik'];
//echo $_SESSION['idPdstut'];

//header("Location:draftlaporan?type=pidsus1");
//header("Location:draftlaporandik?id=".$_SESSION['idPdsDik']);

?>
<div class="pds-dik-update">


    <?= $this->render('_form', [
        'model' => $model,
    	'modelTersangkaUpdate'=>$modelTersangkaUpdate,
        //  'typeSurat' => $typeSurat,
        'titleForm' => 'Update Laporan/Pengaduan',
    ]) ?>

</div>
