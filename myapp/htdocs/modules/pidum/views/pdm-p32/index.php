<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\pdmP11Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pidum-pdm-p11-index">

   
   <?php
        $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-p11',
            'action' => '/pidum/pdm-p31/delete'
        ]);
    ?>
    <div id="divHapus">
       <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
       <button class='btn btn-warning' id="btn-hapus" type='submit'>hapus</button>
    </div>
    <div id="btnHapus"></div><div id="btnUpdate"></div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <?= GridView::widget([
        //'id' => 'p11',
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_p31']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            'no_surat',
            'dikeluarkan',
           
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->id_p31];
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
          ]); ?>

</div>
<?php
    $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p31/update?id="+id;
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
            //     "<a href='/pidum/p31/update?id="+e.target.value+"' class='btn btn-primary ubah'>Ubah</a>"
            // );
            $('#divHapus').append(
                "<input type='hidden' id='"+e.target.value+"' name='hapusp31[]' value='"+e.target.value+"' class='"+e.target.value+"'>"
            );


        }else if(input.prop( "checked" ) == false){
            
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
