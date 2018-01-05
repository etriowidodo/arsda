<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP16 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t5-create">

      <?= $this->render('_form', [
        'model' => $model,
		'modelSpdp' =>$modelSpdp,		
        'modelPerpanjangan' => $modelPerpanjangan,
		'id_perkara'=>$id_perkara,
		'sysMenu'=>$sysMenu
    ]) ?>

</div>
