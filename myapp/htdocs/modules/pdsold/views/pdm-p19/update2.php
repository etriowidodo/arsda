<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP19 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p19-update">
 

    <?= $this->render('_form2', [
        'model' => $model,
		 'model2' => $model2,
		  'model3' => $model3,
		'modelPasalBerkas' => $modelPasalBerkas,
		'modelBerkas' => $modelBerkas,
    	'modelSpdp' => $modelSpdp,
    	'modelTersangka' => $modelTersangka,
    ])

	?>


</div>
