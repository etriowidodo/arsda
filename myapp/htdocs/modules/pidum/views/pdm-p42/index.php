<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\VwTerdakwaT2;
use yii\web\Session;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP42Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p42-index">
 <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-p42/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
         'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->no_surat_p42];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute'=>'no_surat_p42',
                'label' => 'No. Surat P-42',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat_p42;
                },
            ],
                        
            [
                'attribute'=>'tgl_dikeluarkan',
                'label' => 'Tanggal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tgl_dikeluarkan;
                },
            ],
                       
//            [
//                'attribute'=>'ket_tersangka',
//                'label' => 'Tersangka',
//                'format' => 'raw',
//                'value'=>function ($model, $key, $index, $widget) {
////                    echo $no_register;exit();
////                    $no_register    = $session->get('no_register_perkara');
//                    $modeltsk       = VwTerdakwaT2::findAll(['no_register_perkara'=> $no_register]);
////                    print_r($modeltsk);exit();
//                    $terdakwax = '';
//                    $no = 1;
//                    for ($i=0; $i < count($modeltsk); $i++) { 
//                        $terdakwax .= $no.'. '.$modeltsk[$i][nama].'<br>';
//                        $no++;
//                    }
//                    return $terdakwax;
//                },
//            ],
                        
             [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model->no_surat_p42, 'class' => 'checkHapusIndex'];
                    }
            ],                    
         ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>

</div>

<?php
 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var no_surat_p42 = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p42/update?no_surat_p42=" + no_surat_p42;
        $(location).attr('href',url);
    });

JS;

    $this->registerJs($js);
?>