<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP9 */

//$this->title = 'Surat Panggilan Saksi / Tersangka';

 $this->title = $sysMenu->kd_berkas;
 $this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-p9-update">

       <?= $this->render('_form', [
        'model' => $model,
		'modelPanggilanSaksi' => $modelPanggilanSaksi,
		'modelSpdp' => $modelSpdp,
		'id'=>$id,
		'sysMenu'=>$sysMenu,
    ]) ?>

</div>
