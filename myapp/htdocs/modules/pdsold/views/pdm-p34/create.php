<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP34 */



$this->title = 'P34';
$this->subtitle = 'Tanda Terima Barang Bukti';
?>
<div class="pdm-p34-create">

    <?= 
	$this->render('_form', [
						'model' => $model,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modelTersangka' => $modelTersangka,
                        'id' => $id,
                        'modelSpdp' => $modelSpdp,
                        'modeljapen' => $modeljapen,
    ]) 
	?>

</div>
