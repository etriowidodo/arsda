<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP44 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p44-create">

     <?= $this->render('_form', [
        'model' => $model,
    	'modelSpdp' => $modelSpdp,
    	'dataJPU' => $dataJPU,
    	'searchJPU' => $searchJPU,
    	'wilayah' => $wilayah,
    	'listTersangka' => $listTersangka,
		'modeljaksasaksi' => $modeljaksasaksi,
         'modeljaksapenerima' => $modeljaksapenerima,
    ]) ?>

</div>
