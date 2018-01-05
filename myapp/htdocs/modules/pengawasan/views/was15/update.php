<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was15 */

$this->title = 'WAS-15';
$this->subtitle = 'Nota Dinas Pertimbangan Terhadap Hukuman Disiplin Yang Akan Dijatuhkan Kepada Terlapor ';
$this->params['ringkasan_perkara'] = $model->id_register;
//$this->params['breadcrumbs'][] = ['label' => 'Was15s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_15, 'url' => ['view', 'id' => $model->id_was_15]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was15-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan'=>$modelTembusan,
        'no_register' => $no_register,
        'was_register' => $was_register,
        'modelData' => $modelData,
        'modelAnalisa' => $modelAnalisa,
        'modelKesimpulan' => $modelKesimpulan,
        'modelMemberatkan'=>$modelMemberatkan,
        'modelMeringankan' => $modelMeringankan,
        'modelSaran' => $modelSaran,
    ]) ?>

</div>
