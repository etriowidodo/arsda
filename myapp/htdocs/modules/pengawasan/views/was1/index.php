<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
// use kartik\grid\DataColumn;
// use yii\helpers\Url;
// use yii\web\View;


/* @var $this yii\web\View */
/* @var $searchModel app\models\LapduSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Lapdu';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php// print_r($_SESSION); ?>
<div class="lapdu-index">

    <h4><?php ?></h4>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('Create Lapdu', ['create'], ['class' => 'btn btn-success']) ?>
         <div class="btn-toolbar">
              <!-- <a class="btn btn-primary btn-sm pull-right" id="hapus_lapdu"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp; -->
              <a class="btn btn-primary btn-sm pull-right" id="ubah_irmud"><i class="glyphicon glyphicon-pencil">  </i> Ubah</a>&nbsp;
              <!-- <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/lapdu/create"><i class="glyphicon glyphicon-plus"> Laporan Pengaduan</i></a> -->
            </div>
    </p>
    <style type="text/css">
fieldset.group-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend.group-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
    font-size: 14px;
}
</style>
     <fieldset class="group-border">
        <legend class="group-border">Daftar laporan Pengaduan</legend>
    <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
         // 'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'header'=>'No'],

            'no_register',
            // ['label' => 'Register',
            //           'value' => function ($data) {
            //             return $data['satker_terlapor_awal']; 
            //           },
            //       ],
			
			 ['label' => 'Satuan Kerja Terlapor',
                      'value' => function ($data) {
                         return $data['satker_terlapor_awal']; 
                      },
                  ],
			
			['label' => 'Terlapor',
                      'value' => function ($data) {
                         return $data['nama_terlapor_awal']; 
                      },
                  ],
			
			['label' => 'Sumber Laporan',
                      'value' => function ($data) {
                         return $data['nama_sumber_laporan']; 
                      },
                  ],
				  
			['label' => 'Perihal',
                      'value' => function ($data) {
                         return $data['perihal_lapdu']; 
                      },
                  ],	  
				  
			['label' => 'Pelapor',
                      'value' => function ($data) {
                         return $data['nama_pelapor']; 
                      },
                  ],	  
            //'satker_terlapor_awal',
            //'nama_terlapor_awal',
            //'nama_sumber_laporan',
            //'perihal_lapdu:ntext',
            //'nama_pelapor',
			  ['label' => 'Status Akhir',
                       'value' => function ($data) {
                         return $data['status']; 
                       },
                   ], 
				   
			 /* ['label' => 'IRMUD',
                       'value' => function ($data) {
                         if ($data['cek1']=='1'){
							return  'Irmud PEGASUM dan KEPBANG';
						}elseif ($data['cek2']=='1'){
							return 'Irmud PIDUM dan DATUN';
						}elseif ($data['cek3']=='1'){
							return 'Irmud INTEL dan PIDSUS';
						}
                       },
                   ], */	   
            
                // // ...
                [
                    'class' => 'yii\grid\CheckboxColumn',
                       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
                    // you may configure additional properties here
					 'contentOptions'=>['style'=>'width: 9px;'],
                       'checkboxOptions' => function ($data) {
                        return ['value' => $data['no_register'],'class'=>'checkbox-row'];
                        },


                ],
                // manual checkbox
            // [
            // 'label' =>'',
            // 'format' => 'raw',
            // 'value' => function($data)
            // {
            //     return Html::checkbox('chk1', false, ["class" => "chk1",'value' => $data['no_register']]);
            // },
            // ],


            /*manual button*/
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{Tampil}{Edit}{Hapus}',
            //     'buttons' => [
            //         'Tampil' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/view?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-eye-open']);
                        
            //         },
            //         'Edit' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/update?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-pencil']);
                        
            //         },
            //         'Hapus' => function ($url,$data) {

            //             return Html::a('', ['/pengawasan/lapdu/delete?id='.$data['no_register']], ['class'=>'glyphicon glyphicon-trash']);
                        
            //         },
            //     ],
            // ],
            ],
         
    ]); ?>
</fieldset>
</div>
<style type="text/css">
    tr.hover {
  background-color: #FFFFCC;
}

tr.click-row {
  background-color: #81bcf8;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
$('.table-bordered tr').hover(function() {
      $(this).addClass('hover');
    }, function() {
      $(this).removeClass('hover');
    });

$('.table-bordered tr').on('click', function() {
      // $('.table-bordered tr').not(this).removeClass('click-row')
      $(this).toggleClass('click-row');
      // $(this).find('.checkbox-row').attr('checked','checked');
      // $(this).find('.checkbox-row').prop('checked',false);
      
      // var x=$(this).find('.checkbox-row:checked').attr('checked');
      // if(x!=''){
      //   $(this).toggleClass('click-row');
      //   // $(this).find('.checkbox-row').attr('checked','checked');
      // }else {
      //   // $(this).removeClass('click-row');
      //   $(this).find('.checkbox-row').attr('checked',false);
      // }
      var z=$(this).attr('class');
      if(z=='hover'){
       $(this).find('.checkbox-row').prop('checked',false);
        $("#ubah_irmud").addClass("disabled");
        $("#hapus_lapdu").addClass("disabled");
      }else{
        $(this).find('.checkbox-row').prop('checked',true);
        $("#ubah_irmud").removeClass("disabled");
        $("#hapus_lapdu").removeClass("disabled");
      }
      // alert(z);
});

    $("#ubah_irmud").addClass("disabled");
    $("#hapus_lapdu").addClass("disabled");
    /*permintaan pa putut*/
    $(".checkbox-row").click(function(){
            var x=$(".checkbox-row:checked").length;
            if(x>0){
         $("#ubah_irmud").removeClass("disabled");
         $("#hapus_lapdu").removeClass("disabled");

                
        }else{
          $("#ubah_irmud").addClass("disabled");
          $("#hapus_lapdu").addClass("disabled");      
            }
    // alert(x);
    });

    $('#ubah_irmud').click(function(){
        
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
       if(x>=2 || x<=0){
            var warna='black';
            bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-primary",

                    }
                }
            });
			//notify(warna);
         return false
         }else{
            
        location.href='/pengawasan/was1/index?id='+link;
         }
    });

        
    $('#hapus_lapdu').click(function(){
        var x=$(".checkbox-row:checked").length;
         // var link=$(".chk1:checked").val();
         /*alert(x);
         exit();*/
        if(x<=0){
   //          var warna='black';
         
			// notifyHapus(warna);
         return false
         }else{
          
             bootbox.dialog({
                        title: "Peringatan",
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){   
                                var checkValues = $('.checkbox-row:checked').map(function()
                                {
                                    return $(this).val();
                                }).get();
                             //alert(checkValues);

                                $.ajax({
                                    type:'POST',
                                    url:'/pengawasan/lapdu/delete',
                                    data:'id='+checkValues+'&jml='+x,
                                    success:function(data){
                                        //alert(data);
                                    }
                                    });                           
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });
        
        }
            });

$('tr').dblclick(function(){
  var id = $(this).find('.checkbox-row').val();
  // alert(id);
         location.href='/pengawasan/was1/index?id='+id;   
  //do something with id
});
});

function notify(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Merubah data harus memilih satu data,Harap pilih satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
function notifyHapus(style) {
        $.notify({
            title: 'Error Notification',
            text: 'Menghapus data harus memilih salah data,Harap pilih salah satu data'
            // image: "<img src='images/Mail.png'/>"
        }, {
            style: 'metro',
            className: style,
            autoHide: true,
            clickToHide: true
        });
        }
</script>


