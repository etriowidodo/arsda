<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\pengawasan\models\PemeriksaBawas3;
use yii\db\Query;
use yii\db\Command;

$this->title = 'Daftar SK-WAS-4A';
$this->params['breadcrumbs'][] = $this->title;
// $this->params['ringkasan_perkara'] = $_SESSION['was_register'];
$this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<?php// print_r($_SESSION); ?>
<div class="sk-was4a-index">

    <h4><?php ?></h4>
    <?php //  echo $this->render('_search', ['model' => $searchModel]); ?>
<!-- href="/pengawasan/sk-was-4a/create" -->
    <p>
        <div class="btn-toolbar">
              <a class="btn btn-primary btn-sm pull-right" id="cetak_skwas4a"><i class="glyphicon glyphicon-print"> </i> Cetak </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="hapus_skwas4a"><i class="glyphicon glyphicon-trash"> </i> Hapus </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="ubah_skwas4a"><i class="glyphicon glyphicon-pencil"> </i> Ubah </a>&nbsp;
              <a class="btn btn-primary btn-sm pull-right" id="create_skwas4a" ><i class="glyphicon glyphicon-plus"> </i> SK-WAS-4A</a>
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
        <legend class="group-border">Daftar SK-WAS-4A</legend>
    <?= GridView::widget([
        
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'tableOptions' => ['class' => 'table table-striped table-bordered table-hover','id'=>'tabel','data-id' => $data['id_ba_was_3']],
         // 'layout' => "{items}\n{pager}",
        'columns' => [
                 ['header'=>'No',
                 'class' => 'yii\grid\SerialColumn'],
            
                  ['label' => 'No SK.WAS-4A',
                          'value' => function ($data) {
                             return $data['no_sk_was_4a']; 
                          },
                      ],
            
                  ['label' => 'Nama Terlapor',
                              'value' => function ($data) {
                                 return $data['nama_terlapor']; 
                              },
                          ],
            
                  ['label' => 'Nama Pemeriksa',
                                'format'=>'raw',
                                 'value' => function ($data) {
                                
                                return $data['nama_pemeriksa'];
                                        },
                                    ],

                  ['label' => 'Bentuk Pelanggaran',
                              'value' => function ($data) {
                                 return $data['keterangan']; 
                              },
                          ],
                  ['label' => 'Pasal Pelanggaran',
                              'value' => function ($data) {
                                 return $data['pasal']; 
                              },
                          ],

                          // ['label' => 'Pilih',
                          //     'value' => function ($data) {
                          //        return $data['keterangan']; 
                          //     },
                          // ],        
                  
                [
                    'class' => 'yii\grid\CheckboxColumn',
                       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
                    // you may configure additional properties here
                                   'contentOptions'=>['style'=>'width: 9px;'],
                       'checkboxOptions' => function ($data) {
                        $result=json_encode($data);
                        return ['value' => $data['nip_terlapor'],'json'=>$result,'class'=>'checkbox-row'];           
                        },


                ],
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

// $('.table-bordered tr').hover(function() {
//       $(this).addClass('hover');
//     }, function() {
//       $(this).removeClass('hover');
//     });

// $('.table-bordered tr').on('click', function() {
//       $(this).toggleClass('click-row');
//       var z=$(this).attr('class');
//       if(z=='hover'){
//        $(this).find('.checkbox-row').prop('checked',false);
//         $("#create_skwas4a").addClass("disabled");
//         $("#ubah_skwas4a").addClass("disabled");
//         $("#hapus_skwas4a").addClass("disabled");
//         $("#cetak_skwas4a").addClass("disabled");
//       }else{
//         $(this).find('.checkbox-row').prop('checked',true);
//         $("#create_skwas4a").removeClass("disabled");
//         $("#ubah_skwas4a").removeClass("disabled");
//         $("#hapus_skwas4a").removeClass("disabled");
//         $("#cetak_skwas4a").removeClass("disabled");
//       }
//       // alert(z);
// });

//     $("#create_skwas4a").addClass("disabled");
//     $("#ubah_skwas4a").addClass("disabled");
//     $("#hapus_skwas4a").addClass("disabled");
//     $("#cetak_skwas4a").addClass("disabled");
//     /*permintaan pa putut*/
//     $(".checkbox-row").click(function(){
//             var x=$(".checkbox-row:checked").length;
//             if(x>0){
//          $("#create_skwas4a").removeClass("disabled");
//          $("#ubah_skwas4a").removeClass("disabled");
//          $("#hapus_skwas4a").removeClass("disabled");
//          $("#cetak_skwas4a").removeClass("disabled");
                
//         }else{
//           $("#create_skwas4a").addClass("disabled");
//           $("#ubah_skwas4a").addClass("disabled");
//           $("#hapus_skwas4a").addClass("disabled");
//           $("#cetak_skwas4a").addClass("disabled");       
//             }
//     // alert(x);
//     });


$("#create_skwas4a").addClass("disabled");
    $("#ubah_skwas4a").addClass("disabled");
    $("#hapus_skwas4a").addClass("disabled");
    $("#cetak_skwas4a").addClass("disabled");
    /*permintaan pa putut*/
   $(document).on('change','.select-on-check-all',function() {
        var c = this.checked ? true : false;
        if(c==true){
          $('.checkbox-row').closest('tr').addClass('danger');
        }else{
          $('.checkbox-row').closest('tr').removeClass('danger');
        }
        // $('.checkbox-row').prop('checked',c);
        var x=$('.checkbox-row:checked').length;
        ConditionOfButton(x);
    });
        
    $(document).on('change','.checkbox-row',function() {
        var c = this.checked ? '#f00' : '#09f';
        if(c=='#f00'){
        $(this).closest('tr').addClass('danger');
        }else{
        $(this).closest('tr').removeClass('danger');
      }

        var x =$('.checkbox-row:checked').length;
        ConditionOfButton(x);
    });

  function ConditionOfButton(n){
        if(n == 1){
           $('#cetak_skwas4a,#ubah_skwas4a,#create_skwas4a, #hapus_skwas4a').removeClass('disabled');
        } else if(n > 1){
           $('#hapus_skwas4a').removeClass('disabled');
           $('#cetak_skwas4a,#ubah_skwas4a,#create_skwas4a').addClass('disabled');
        } else{
           $('#cetak_skwas4a,#ubah_skwas4a,#create_skwas4a, #hapus_skwas4a').addClass('disabled');
        }
    }

    $('#create_skwas4a').click(function(){
        
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
        var check=JSON.parse($('.checkbox-row:checked').attr('json'));
          // alert(id); 
       if(x>=2 || x<=0){
            var warna='black';
            bootbox.dialog({
                message: "Silahkan pilih hanya 1 data untuk tambah data",
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
           if(check.nip_trlp != null){
            alert('Data Sudah Ada');
           }else{
            location.href='/pengawasan/sk-was-4a/create?id='+check.nip_terlapor+'&id2='+check.pasal;
           } 
         }
    });

    $('#ubah_skwas4a').click(function(){
        
        var x=$(".checkbox-row:checked").length;
        var link=$(".checkbox-row:checked").val();
        var check=JSON.parse($('.checkbox-row:checked').attr('json'));
          // alert(id); 
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
            if(check.id_sk_was_4a == null){
               bootbox.alert({
                      message:"Data Belum Bisa Di Rubah Nomor Harus Di Isi",
                      size:'small'
                  });
             }else{
                location.href='/pengawasan/sk-was-4a/update?id='+check.id_sk_was_4a+'&id2='+check.nip_pegawai_terlapor+'&id3='+check.pasal;
             }
         }
    });

    $(document).on('click', '#cetak_skwas4a', function () {

          // alert()
          var x=$(".checkbox-row:checked").length;
          var link=$(".checkbox-row:checked").val();
          var check=JSON.parse($('.checkbox-row:checked').attr('json'));
         // alert(check.id_sk_was_4a);
          //var data=JSON.parse(result);
          if(check.id_sk_was_4a == null){
             bootbox.alert({
                    message:"Data Belum Bisa Di Cetak Nomor Harus Di Isi",
                    size:'small'
                });
           }else{
              location.href='/pengawasan/sk-was-4a/cetak?id='+check.id_sk_was_4a;
           }
          //alert(nilai);
        });

$(document).on('click','#hapus_skwas4a',function(){
  
        var x=$(".checkbox-row:checked").length;
        //alert(x);
         if(x<=0){
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
                                      return $(this).attr('json');
                                }).get();
                                 var jml=$('.checkbox-row:checked').length;
                                    for (var i = 0; i<jml; i++) {
                                        var data=JSON.parse(checkValues[i]);
                                        $.ajax({
                                            type:'POST',
                                            url:'/pengawasan/sk-was-4a/delete',
                                            data:'id='+data.id_sk_was_4a+'&jml='+jml,
                                            success:function(data){
                                                alert(data);
                                            }
                                            });

                                    };                          
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
});

    $(document).ready(function(){

            $('tr').dblclick(function(){
                var check=JSON.parse($('.checkbox-row').attr('json'));
                location.href='/pengawasan/sk-was-4a/update?id='+check.id_sk_was_4a+'&id2='+check.nip_pegawai_terlapor+'&id3='+check.pasal;
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


