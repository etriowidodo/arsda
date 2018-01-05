<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\Was16cSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Was16cs';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<div class="was16c-index">

    <h1><?//= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <div class="btn-toolbar role">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_was16c"><i class="glyphicon glyphicon-print"> </i> Cetak</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_was16c"><i class="glyphicon glyphicon-trash"> </i> Hapus</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_was16c"><i class="glyphicon glyphicon-pencil"> </i> Ubah</a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was16c/create"><i class="glyphicon glyphicon-plus"> </i> WAS-16c</a>
        </div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'columns' => [
            ['header'=>'No',
                 'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                 'contentOptions'=>['style'=>'text-align:center;'],            
                'class' => 'yii\grid\SerialColumn'],

            ['header'=>'No Register',
                 'headerOptions'=>['style'=>'text-align:center;'],            
                 'attribute'=>'no_register',
                ],
            ['header'=>'Tanggal',
                 'headerOptions'=>['style'=>'text-align:center;'],     
                 'value' => function ($data) {
                    return \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_16c']);
                 }       
                 // 'attribute'=>'tgl_was_16c',
                ],
            ['header'=>'Nip/Nrp',
                 'format'=>'raw',
                 'headerOptions'=>['style'=>'text-align:center;'],            
                 'value' => function ($data) {
                                return $data['nip_pegawai_terlapor'].($data['nrp_pegawai_terlapor']==''?'':'/'.$data['nrp_pegawai_terlapor']); 
                             },
                ],
            ['header'=>'Nama',
                 'headerOptions'=>['style'=>'text-align:center;'],            
                 'attribute'=>'nama_pegawai_terlapor',
                ],
            ['header'=>'Perihal',
                 'headerOptions'=>['style'=>'text-align:center;'],            
                 'attribute'=>'perihal',
                ],


            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions'=>['style'=>'text-align:center;width:4%;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                   'checkboxOptions' => function ($data) {
                    $json=json_encode($data);
                    return ['value' => $data['id_was_16c'],'class'=>'selection_one', 'json'=>$json];
                    },
            ],
        ],
    ]); ?>

</div>
<script type="text/javascript">
window.onload=function(){

     $(document).on('click', '#ubah_was16c', function () {
          var data=JSON.parse($('.selection_one:checked').attr('json'));
          location.href='/pengawasan/was16c/update?id_was_16c='+data.id_was_16c;   
        });

      $(document).on('click', '#cetak_was16c', function () {
          var data=JSON.parse($('.selection_one:checked').attr('json'));
          location.href='/pengawasan/was16c/cetakdocx?id_was_16c='+data.id_was_16c;   
        });


     $(document).on('click', '#hapus_was16c', function () {
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
                                                        return $(this).attr('json');
                                                    }).get();
                                 var jml=$('.selection_one:checked').length;
                                    // var pecah=checkValues.split(',');
                                    for (var i = 0; i<jml; i++) {
                                        var data=JSON.parse(checkValues[i]);
                                        $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/was16c/delete',
                                            data:'id_was_16c='+data.id_was_16c+'&jml='+jml,
                                            success:function(data){

                                            }
                                            });

                                    };
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

    $('#cetak_was16c,#ubah_was16c, #hapus_was16c').addClass('disabled');

    $(document).on('change','.select-on-check-all',function() {
            var c = this.checked ? true : false;
                if(c==true){
                 $('tbody tr').addClass('danger');
                }else{
                $('tbody tr').removeClass('danger');
                }
            var x=$('.selection_one:checked').length;
            ConditionOfButton(x);
        });
            
        $(document).on('change','.selection_one',function() {
            var c = this.checked ? '#f00' : '#09f';
            if(c=='#f00'){
            $(this).closest('tr').addClass('danger');
            }else{
            $(this).closest('tr').removeClass('danger');
            }
            var x =$('.selection_one:checked').length;
            ConditionOfButton(x);
        });


        function ConditionOfButton(n){
                if(n == 1){
                   $('#cetak_was16c,#ubah_was16c, #hapus_was16c').removeClass('disabled');
                } else if(n > 1){
                   $('#hapus_was16c').removeClass('disabled');
                   $('#cetak_was16c,#ubah_was16c').addClass('disabled');
                } else{
                   $('#cetak_was16c,#ubah_was16c, #hapus_was16c').addClass('disabled');
                }
        }
}


  $(document).ready(function(){

          $('tr').dblclick(function(){
            var id = $(this).find('.selection_one').val();
                  location.href='/pengawasan/was16c/update?id_was_16c='+id; 
        });

     });
</script>
