<?php

use yii\helpers\Html;
use kartik\grid\GridView;
// use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\pdmt7Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdmt7-index">
    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pidum/pdm-t7/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1">
        <button type="button" id="apus" class='btn btn-warning '>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_register_perkara'],'data-no_surat_t7'=>$model['no_surat_t7']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id_tersangka',
                'label' => 'Terdakwa',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['nama_tersangka'];
                },


            ],

            [
                'attribute'=>'tindakan_status',
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['tindakan_status'] == 1 ? 'Penahanan' : 'Pengalihan Jenis Penahanan';
                    
                },


            ],
            [
                'attribute'=>'id_jaksa_saksi',
                'label' => 'Jaksa Penuntut Umum',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $val1 = '';
                    $jpu = json_decode($model['json_jpu']);
                            if($jpu->no_urut!=null){
                            foreach($jpu->no_urut AS $key=>$val)
                            {
                                $val1 .= $val.' .'.$jpu->nama_jpu[$key].'<br>';
                            }
                        }
                     return $val1;
                },


            ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_register_perkara']."_".$model['no_surat_t7'], 'class' => 'checkHapusIndex'];
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
            console.log('hallo');

        var no_register_perkara = $(this).closest('tr').data('id');
        var no_surat_t7         = $(this).closest('tr').data('no_surat_t7');

        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-t7/update?no_register_perkara=" + no_register_perkara+"&no_surat_t7="+no_surat_t7;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);

     $("#apus").on("click",function(){
        $('form').submit();
    });
JS;

    $this->registerJs($js);
?>