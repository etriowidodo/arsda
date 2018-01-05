<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\pdmP11Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pidum-pdm-p11-index">

   
   <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-p11/delete/'
        ]);  
    ?>  
       <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    <?= GridView::widget([
        //'id' => 'p11',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_p11']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id_p11',
            // 'id_perkara',
            'no_surat',
            'sifat',
            'lampiran',
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id_p11];
                }
            ],
        ],
        'toolbar'=> [
            ['content'=>
                Html::a(Yii::t('app', 'Tambah P13'), ['create'], ['class' => 'btn btn-success']),
             
            ],
            '{toggleData}',
        ],

        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        // 'panel' => [
        //     'type' => GridView::TYPE_SUCCESS,
        //     'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
        // ],
    ]); ?>

</div>
<?php
    $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p11/update2?id="+id;
        $(location).attr('href',url);
    });


    $( "input" ).change(function(e) {
        var input = $( this );
        if(input.prop( "checked" ) == true){
            //console.log(e.target.value);
            // $('#btnHapus').html(
            //     "<button class='btn btn-danger' type='submit'>hapus</button>"
            // );
            // $('#btnUpdate').html(
            //     "<a href='/pdsold/p13/update2?id="+e.target.value+"' class='btn btn-primary ubah'>Ubah</a>"
            // );
            $('#divHapus').append(
                "<input type='text' id='"+e.target.value+"' name='hapusp11[]' value='"+e.target.value+"'>"
            );


        }else{
            
                $("#"+e.target.value+"").remove();
            
        }
        // $('.ubah').click(function(){
        //     if($('input#hapus').length > 1){
        //         alert('Harap Pilih Satu Perkara untuk Update Data');
        //         location.reload();
        //         return false;
        //     }
        // });

    });
JS;

    $this->registerJs($js);
?>
