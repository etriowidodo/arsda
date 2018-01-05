<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\LWas2 */

$this->title = 'L-WAS 2';
$this->subtitle = 'LAPORAN HASIL INSPEKSI KASUS';
$this->params['ringkasan_perkara'] = $model->id_register;
$this->params['breadcrumbs'][] = ['label' => 'Lwas2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_l_was_2, 'url' => ['view', 'id' => $model->id_l_was_2]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lwas2-update">

   

    <?= $this->render('_form', [
         'model' => $model,
                'modelBarbuk' => $modelBarbuk,
                'modelAnalisa' => $modelAnalisa,
                'modelKesimpulan' => $modelKesimpulan,
                'modelPendapat' => $modelPendapat,
                'modelPertimbanganBerat' => $modelPertimbanganBerat,
                'modelPertimbanganRingan' => $modelPertimbanganRingan,
    ]) ?>

</div>
