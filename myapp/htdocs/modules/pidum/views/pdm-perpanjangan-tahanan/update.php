<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPerpanjanganTahanan */

$this->title = 'Permintaan Perpanjangan Penahanan';// . ' ' . $model->id; <!-- jaka |02-06-2016|menambahkan label dari sebelumnya "Perpanjangan Tahanan" menjadi "Permintaan Perpanjangan Tahanan" -->

?>
<div class="pdm-perpanjangan-tahanan-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelAsalSurat' => $modelAsalSurat,
        'modelPenyidik' => $modelPenyidik,
		'modelListTersangka' => $modelListTersangka,
		'maxPendidikan'    => $maxPendidikan,
         'modelPdmSpdp'       => $modelPdmSpdp
    ]) ?>

</div>
