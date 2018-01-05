<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPratutPutusan */

$this->title = 'Penyelesaian Pra Penuntutan';

?>
<div class="pdm-pratut-putusan-create">
    
    <?= $this->render('_form', [
        'model' => $model,
		'satker'=>$satker,
        'modelSpdp'=>$modelSpdp,
			'pengadilan'=>$pengadilan,
				'id_berkas'=>$id_berkas
    ]) ?>

</div>
