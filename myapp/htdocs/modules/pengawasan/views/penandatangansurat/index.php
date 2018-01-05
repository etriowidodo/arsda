<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penandatangan Surat Master';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penandatangan-surat-master-index">
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <div class="btn-toolbar role-index">
              <!-- <a class="btn btn-primary btn-sm pull-right" id="detail_ttdsurat" href="#" data-toggle= "modal" data-target ="#_mdetail"><i class="glyphicon glyphicon-modal-window"> Detail</i></a> -->
              <a class="btn btn-primary btn-sm pull-right" id="hapus_ttdsurat"><i class="glyphicon glyphicon-trash">  </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_ttdsurat"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/penandatangansurat/create"><i class="glyphicon glyphicon-plus"> </i> Penandatangan Surat</a>
            </div>
    </p>
<?php $form = ActiveForm::begin(
        ['action' => '/pengawasan/penandatangansurat/delete', 'id' => 'forum_post', 'method' => 'post',]
    ); ?>
    <div class="box box-primary" id="grid-penandatangan_surat" style="padding: 15px;overflow: hidden;">
    <?php Pjax::begin(['id' => 'Mpenandatangan-grid', 'timeout' => false,'formSelector' => '#searchForm','enablePushState' => false]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        // 'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
                            return ['data-id' => $model['id_surat'].'#'.$model['nip'].'#'.$model['id_jabatan'].'#'.$model['unitkerja_kd']];
                        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_surat',
            'nip',
            // 'id_jabatan',
            [
                'label' => 'Nama Penandatangan Surat',
                'attribute'=>'nama_penandatangan'
            ],
            [
            'label' => 'Jabatan Penandatangan',
            'attribute' => 'jabatan',
            ],
            // 'kode_level',
            // 'created_ip',
            // 'created_time',
            // 'updated_ip',
            // 'updated_by',
            // 'updated_time',

            //['class' => 'yii\grid\ActionColumn'],
            [
                    'class' => 'yii\grid\CheckboxColumn',
             'headerOptions'=>['style'=>'width: 4%;'],
                       'checkboxOptions' => function ($data) {
                        $result=json_encode($data);
                        // $connection = \Yii::$app->db;
                        // $sql="select string_agg(id_jabatan,',') from (select id_jabatan from was.was_jabatan where upper(nama) in ('".'PLT. '.rtrim(strtoupper($data['nama']))."','".'PLH. '.rtrim(strtoupper($data['nama']))."','".'AN. '.rtrim(strtoupper($data['nama']))."') order by id_jabatan)a";
                        // $result_query=$connection->createCommand($sql)->queryOne();
                        return ['value' => $data['id_penandatangan_surat'],'class'=>'selection_one','json'=>$result,'id_surat'=>$data['id_surat'].'#'.$data['kode_level']];
            
                        },


                ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
<div class="modal-loading-new"></div>
</div>
<?php ActiveForm::end(); ?>
</div>
<style>
  #grid-penandatangan_surat.loading {overflow: hidden;}
  #grid-penandatangan_surat.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
$("#Mpenandatangan-grid").on('pjax:send', function(){
      $('#grid-penandatangan_surat').addClass('loading');
    }).on('pjax:success', function(){
      $('#grid-penandatangan_surat').removeClass('loading');
    });

$(document).ready(function(){

$("#ubah_ttdsurat").addClass("disabled");
    $("#hapus_ttdsurat").addClass("disabled");
    $("#detail_ttdsurat").addClass("disabled");

$('tr').dblclick(function (e) {
        var id = $(this).closest('tr').data('id').split('#');
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/penandatangansurat/update?id="+id[0]+"&nip="+id[1]+"&idjab="+id[2];
        $(location).attr('href',url);
        
    });
$('#detail_ttdsurat').click(function(){
     var data = JSON.parse($('.selection_one:checked').attr('json'));
     var q = JSON.parse($('.selection_one:checked').attr('query'));
     var var_idsurat = $('.selection_one:checked').attr('id_surat');

     $('#namasurat').val(data.id_surat);
     $('#nama_penadatangan_asli').val(data.nama_penandatangan);
     $('#jabatan_asli').val(data.nama);
            $.ajax({
                    type:'POST',
                    url:'getdetail',
                    data:'id='+q.string_agg+'&id_surat='+var_idsurat+'&unitkerja_kd='+data.unitkerja_kd,
                    success:function(data){
                        // alert(data);
                        $('.bd_detail').html(data);
                    }
                    });
        
        
});

$('#ubah_ttdsurat').click (function (e) {

        var count =$('.selection_one:checked').length;
        if (count != 1 )
        {
         bootbox.dialog({
                message: "<center>Silahkan pilih hanya 1 data untuk diubah</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
        } else {
            // var id = $(this).closest('tr').data('id').split('#');
        var id = $('.selection_one:checked').val();
        
       // alert(id_jabatan[0]);
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/penandatangansurat/update?id="+id;
        $(location).attr('href',url);
        }
    });

$('#hapus_ttdsurat').click(function(){
    var x         =$(".selection_one:checked").length;
        bootbox.dialog({
                title: "Peringatan",
                message: "Apakah anda ingin menghapus data ini?",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-primary",
                        callback: function(){   
                        var checkValues = $('.selection_one:checked').map(function()
                        {
                            return $(this).val();
                        }).get();
                     //alert(checkValues);

                        $.ajax({
                            type:'POST',
                            url:'/pengawasan/penandatangansurat/delete',
                            data:'id='+checkValues+'&jml='+x,
                            success:function(data){
                                alert(data);
                            }
                            });                           
                        }
                    },
                    tidak : {
                        label: "Tidak",
                        className: "btn-primary",
                        callback: function(result){
                            console.log(result);
                        }
                    },
                },
            });

});

});

window.onload=function(){
     $(document).on('change', '.select-on-check-all', function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $('tbody tr').addClass('danger');
            }else{
                $('tbody tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
        
        $(document).on('change', '.selection_one', function () {
            var c = this.checked ? '#f00' : '#09f';
             if(c=='#f00'){
                $(this).closest('tr').addClass('danger');
            }else{
                $(this).closest('tr').removeClass('danger');
            }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
};
function ConditionOfButton(n){
            if(n == 1){
               $('#ubah_ttdsurat, #hapus_ttdsurat,#detail_ttdsurat').removeClass('disabled');
            } else if(n > 1){
               $('#hapus_ttdsurat').removeClass('disabled');
               $('#ubah_ttdsurat,#detail_ttdsurat').addClass('disabled');
            } else{
               $('#ubah_ttdsurat, #hapus_ttdsurat,#detail_ttdsurat').addClass('disabled');
            }
        }

</script>


<?php
Modal::begin([
    'id' => '_mdetail',
    'header' => 'Detail Penandatangan',
    'options' => [
        'data-url' => '',
        'style' =>'width:100%',
    ],
]);
?> 

<?=
$this->render('_mdetail', [
    'model' => $model,
    'parameter'=>'seharusnya',
])
?>

<?php
Modal::end();
?>