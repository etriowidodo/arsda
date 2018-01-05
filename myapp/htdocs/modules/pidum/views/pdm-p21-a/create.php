<?php

use yii\helpers\Html;

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p21-a-create">

    
    <?= $this->render('_form', [
                'model' => $model,
				'modelPengantar'=>$modelPengantar,
				'dataProvider' => $dataProvider,
				'modelP21'=>$modelP21,
				'sysMenu' => $sysMenu,
    ]) ?>

</div>
