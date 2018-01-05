<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmBerkasTahap1Search;
use app\modules\pdsold\models\PdmUuPasalTahap1;
use app\modules\pdsold\models\PdmJaksaP16;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmBerkasTahap1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RP-7';
$this->subtitle = 'Register Penerimaan Berkas Perkara Tahap I';
//$this->params['breadcrumbs'][] = $this->title;

?>




<div class="pdm-berkas-tahap1-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

     <?php echo $this->render('_search', ['model' => $searchmodel]); ?>

    <div id="divTambah" class="col-md-10">
         <a data-toggle="modal" data-target="#_spdp" class="btn btn-primary cari_spdp">Tambah</a>
         <!-- <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex posisiedit'>Ex-Berkas</button> -->
 </div>
  <div  class="col-md-1 pull-right" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex posisiedit'>Ubah</button>
    </div>
<?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/pdm-berkas-tahap1/delete/'
        ]);
    ?>
    <div id="divHapus" class="col-md-1">
<!--         <button class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
 -->    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
    <?= GridView::widget([
       'dataProvider' => $dataProvider,
       'rowOptions'   => function ($model, $key, $index, $grid) {

            return ['data-id' => $model['id_perkara'], "data-id_berkas"=>$model['id_berkas']];
        },
        'columns' => [
            [
                 'attribute'=>'akronim',
                 'label' => 'Asal Berkas, No & Tgl Penyerahan',
                 'format' => 'raw',
                 'value'=>function ($model, $key, $index, $widget) {

                 return ($model[akronim].'<br>'.$model['no_pengantar'].' Tgl Penyerahan '.date('d-m-Y',strtotime($model[tgl_pengantar])).'<br> Tgl Diterima : '.date('d-m-Y',strtotime($model[tgl_terima_pengantar])));

                 },

             ],

            [
                'attribute'=>'pasal',
                'label' => 'Melanggar UU dan Pasal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $pasal = PdmUuPasalTahap1::find()->select('undang, pasal')->where(['id_pengantar'=>$model->id_berkas.'|'.$model->no_pengantar])->all();
                    //echo '<pre>'.$model->id_berkas.'|'.$model->no_pengantar;print_r($pasal);exit;
                    $no =1;
                    $cetak ='';
                    foreach ($pasal as $key ) {
                        $cetak .= $no.' .'.$key['undang'].' '.$key['pasal'].'<br>';
                    }
                    return $cetak;
                },

            ],

            [
                'attribute'=>'p16',
                'label' => 'P16 Nomor dan Tanggal Jaksa Peneliti',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $p16 = explode('#', $model->p16);
                    $jaksa = PdmJaksaP16::find()->select('nama')->where(['id_p16'=>$p16[0]])->all();
                    //echo '<pre>'.$model->id_berkas.'|'.$model->no_pengantar;print_r($pasal);exit;
                    $no =1;
                    $cetak ='';
                    $cetak .= substr($p16[0], 7,strlen($p16[0])).' '.date('d-m-Y',strtotime($p16[1])).'<br>' ;
                    foreach ($jaksa as $key ) {
                        $cetak .= $no.' .'.$key['nama'].'<br>';
                        $no++;
                    }
                    return $cetak;
                },

            ],


           [
                'attribute'=>'no_berkas',
                'label' => 'Nomor & Tanggal Berkas',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {

                return ($model[no_berkas].'<br>'.date('d-m-Y',strtotime($model[tgl_berkas])));

                },

            ],
           
            [
                'attribute'=>'id_berkas',
                'label' => 'Nama Tersangka',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $tersangka = MsTersangkaBerkas::find()->select('nama')->where(['no_pengantar'=>$model->no_pengantar])->all();
                    //echo '<pre>'.$model->id_berkas.'|'.$model->no_pengantar;print_r($pasal);exit;
                    $no =1;
                    $cetak ='';
                    //$cetak .= substr($p16[0], 7,strlen($p16[0])).' '.date('d-m-Y',strtotime($p16[1])).'<br>' ;
                    foreach ($tersangka as $key ) {
                        $cetak .= $no.' .'.$key['nama'].'<br>';
                        $no++;
                    }
                    return $cetak;
                },

            ],
            // [
                // 'attribute'=>'Tanggal_Terima',
                // 'label' => 'Tanggal Terima',
                // 'format' => 'raw',
                // 'value'=>function ($model, $key, $index, $widget) {

                // return ($model[tglterima]);

                // },

            // ],
            [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        // var_dump($model);exit;
                        return ['value' => $model[id_perkara], 'class' => 'checkHapusIndex','data-id_berkas'=>$model['id_berkas']];
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
                
                
        $(document).ready(function(){
			$('body').addClass('fixed sidebar-collapse');
		});
                
                
        if($(".empty").text()=='Tidak ada data yang ditemukan.'){
        $(".select-on-check-all").hide();
    }
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var grid_berkas = $(this).closest('tr').data('id_berkas');
        //console.log(grid_berkas);
        if(grid_berkas == undefined){
            return false;
        }
        var id_berkas = $(this).closest('tr').data('id_berkas');
        if (id ==undefined)
        {
        bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        }
        else
        {
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1-grid/update-berkas-tahap1/?id="+id+"&id_berkas="+id_berkas;
        $(location).attr('href',url);
        }
        });
$('.posisiedit').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
        if (count != 1 )
        {
         bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
        } else {
        var id =$('.checkHapusIndex:checked').val();
        var id_berkas =$('.checkHapusIndex:checked').attr("data-id_berkas");
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1-grid/update-berkas-tahap1/?id="+id+"&id_berkas="+id_berkas;
        $(location).attr('href',url);
        }
    });


JS;

        $this->registerJs($js);
        ?>
<?php
Modal::begin([
    'id' => '_spdp',
    'header' => 'Data SPDP',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<div class="modalContent">

<?php echo GridView::widget([
        'dataProvider' => $dataProviderx,
        'filterModel' => $searchmodelx,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'no_surat',
                'label' => 'NOMOR dan TANGGAL SPDP',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return $model['no_surat'].'  Tanggal '.$model['tgl_surat'];
                },
            ],
            [
                'attribute' => 'tersangka',
                'label' => 'Tersangka',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    $tersangka = explode(',', $model['tersangka']);
                    //echo '<pre>';print_r($model['tersangka']);exit;
                    $len = count($tersangka);
                    switch ($len) {
                        case 1:
                            $nama=$tersangka[0];
                            break;
                        case 2:
                            $nama=$tersangka[0].' Dan '.$tersangka[1];    
                            break;
                        default:
                            $nama=$tersangka[0].' Dkk';
                            break;
                    }

                    return $nama;
                },
            ],

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model, $key) {
                        return Html::button("Pilih", ["id" => $model['id_perkara'], "class" => "btn btn-warning",
                                    "no_surat" => $model['no_surat'],
                                    "tgl_spdp" => $model['tgl_surat'],
                                    "onClick" => "pilihSpdp($(this).attr('id'))"]);
                    }
                        ],
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
                ],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ]
    ]); ?>
    
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
            <a class="btn btn-danger" data-dismiss="modal" style="color: white">Batal</a>
    </div>

<script>
    function pilihSpdp(id) {

       
        $('#_spdp').modal('hide');

        
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1-grid/create-berkas-tahap1?id="+id;
        $(location).attr('href',url);
    }
    
    
</script>


<?php
$js = <<< JS
    $(document).ajaxSuccess(function(){
        $(".panel-heading").hide();
        $(".kv-panel-before").hide();
        $(".close").hide();
     });
    
     
JS;
$this->registerJs($js);
?>
<?php
Modal::end();
?> 