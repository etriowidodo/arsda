<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP24Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'P24';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = 'RP-9';
$this->subtitle = 'Register Perkara Tahap Penuntutan    ';


?>
<div class="pdm-tahap-dua-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div> 
    
    <?php
        //echo '<pre>';print_r($dataProvider);exit;
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-tahap-dua/delete/'
        ]);  
    ?>  
       <div id="divHapus" class="col-md-1">
        <button type="button" id="apus" class='btn btn-warning btnHapusCheckboxIndexi'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    <?=
    GridView::widget([
        'id' => 'pdm-tahap-dua',
        'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model['no_register_perkara'],'data-berkas' => $model['id_berkas']];
            },
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'no_pengiriman',
                'header' => 'Asal Perkara, No. & Tgl Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {

                return $model[asal].'<br>'.$model['no_surat'].' '.$model[tgl_surat];

                },
            ],
            [
                'attribute' => 'no_pengiriman',
                'header' => 'No. & Tgl P16A (Nama JPU)',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                $p16=explode('^', $model['no_p16a']);
                $jaksa = explode('^', $model['nama_jaksa']);
                $nama = '';
                $no=1;
                //echo '<pre>';print_r(count($jaksa));exit;
                for ($i=0; $i < count($jaksa); $i++) { 
                    $nama .= $no.'. '.$jaksa[$i].'<br>';
                    $no++;
                }
                return $p16[0].' '.$p16[1].'<br>'.$nama;

                },
                //'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'no_pengiriman',
                'header' => 'No Register Perkara dengan Terdakwa',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                $terdakwa = explode('^', $model['tersangka']);
                $terdakwax = '';
                $no = 1;
                for ($i=0; $i < count($terdakwa); $i++) { 
                    $terdakwax .= $no. '. '.$terdakwa[$i].'<br>';
                    $no++;
                }
                return $model['no_register_perkara'].'<br>'.$terdakwax;

                },
            ],
            [
                'attribute' => 'no_pengiriman',
                'header' => 'Didakwa dengan UU & Pasal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                $uu = explode('^', $model['undang']);
                $pasal = explode('^', $model['pasal']);
                $undang ='';
                $no = 1;
                for ($i=0; $i < count($uu); $i++) { 
                    $undang .= $no. '. '.$uu[$i].' - '.$pasal[$i].'<br>';
                    $no++;
                }
                return $undang;

                },
            ],
            [
                'attribute' => 'Status',
                'header' => 'Status',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {

                return $model['status'];

                },
            ],
            
           /* [
                'attribute'=>'tgl_terima',
                'label' => 'Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->tgl_terima;
                },


            ],*/
            [
                'class' => '\kartik\grid\CheckboxColumn',
                //'header' => '',
                'multiple' => true,
                'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['no_register_perkara'],'data-berkas' => $model['id_berkas'], 
                        'class' => 'checkHapusIndex'];
                    }
                
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
        /*'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
        ],*/
    ]); ?>



</div>

<?php

 
    $js = <<< JS
    $(document).ready(function(){
            $('body').addClass('fixed sidebar-collapse');
        });
        $('td').dblclick(function (e) {
        var idTahapDua = $(this).closest('tr').data('id');
        var idBerkas = $(this).closest('tr').attr('data-berkas');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-tahap-dua/update?id=" + idTahapDua+"&berkas="+idBerkas;
        $(location).attr('href',url);
    });

    
    $("#apus").on("click",function(){
        $('form').submit();
    });

JS;

    $this->registerJs($js);

?>


