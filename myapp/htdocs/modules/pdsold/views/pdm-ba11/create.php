<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA12 */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba12-create">


    <?= $this->render('_form', [
        'model' => $model,
        //'tahanan' => $tahanan,
        //'modelt8' => $modelt8,
        //'modelRp9' => $modelRp9,
        //'modelRt3' => $modelRt3,
		//'modelTersangka' => $modelTersangka,
        //'modelSpdp' => $modelSpdp,
        'modeljaksiChoosen' => $modeljaksiChoosen,
        //'modeljaksi' => $modeljaksi,
		//'searchTersangka' => $searchTersangka,
		'modelLokTahanan' => $modelLokTahanan,
		'dataTersangka' => $dataTersangka,
        'no_register_perkara' => $no_register_perkara,
    ]) ?>

</div>
