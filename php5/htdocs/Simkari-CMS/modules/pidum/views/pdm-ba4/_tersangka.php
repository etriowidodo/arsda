<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->

<div class="modal-content" style="width: 500px;margin: 30px auto;">
    <div class="modal-header">
        Data Tersangka

    </div>


    <div class="modal-body">
            <?php
            // Generate a bootstrap responsive striped table with row highlighted on hover
            use kartik\grid\GridView;
            use yii\helpers\Html;

            echo GridView::widget([
                'id'=>'id_tersangka-grid',
                'dataProvider'=> $dataProvider2,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                      'label' => 'Nama',
                      'attribute' => 'nama',
                      'contentOptions' => function ($model, $key, $index, $grid){
                            return ['data-id'=>json_encode($model)];

                        }
                    ],
                    [
                      'label' => 'Tempat Lahir',
                      'attribute' => 'tmpt_lahir',
                      'contentOptions' => function ($model, $key, $index, $grid){
                            return ['data-id'=>json_encode($model)];
                        }
                    ]
                ],
                'export' => false,
                'pjax' => true,
                'responsive'=>true,
                'hover'=>true,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="glyphicon glyphicon-book"></i>',
                ],
            ]);
            ?>
    <div class="modal-footer">
            <a class="btn btn-danger cancel" >Batal</a>
    </div>

    </div>
<?php


//var_dump($dataProvider2);
$this->registerJs(\yii\web\View::POS_BEGIN);

        $js = <<< JS


   //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->
     function editTersangkaPt()
     {
         $('.close').hide();
         $('.panel-heading').hide();
         $('.kv-panel-before').hide();

         var text = $('.panel-heading').text();
         $('#daftar').html(text);
     }

     $(document).ajaxSuccess(function(){

      if($('#id_tersangka-grid-filters td').length>1)
      {
      $('#id_tersangka-grid-filters td').first().remove();
      $('#id_tersangka-grid-filters td').last().remove();
      $('#id_tersangka-grid-filters td').first().attr('colspan',3);
      }

      $('#id_tersangka-grid-filters td input').attr('placeholder','Cari Tersangka');
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         editTersangkaPt();
     });


$(document).ready(function(){

  $('.cancel').click(function()

    {
      $('#m_tersangka').modal('hide');
      $("body").addClass('modal-open');

    });

    // $('#m_tersangka').on('hidden.bs.modal', function () {
    //           $("#m_tersangka").css('overflow-y','scroll');
    //           $("body").css('overflow','hidden');
    //         });
    // $('#m_tersangka').on('show.bs.modal', function () {
    //             $("body").css('overflow','hidden');
    //         });


});


$(document).ajaxSuccess(function(){

       $('#id_tersangka-grid-container td ').off('click').click(function(){
                    var dataId = $(this).attr('data-col-seq');
                    var id_tersangka = $(this).attr('data-id');
                    var data = jQuery.parseJSON(id_tersangka);
                    //console.log(data);
                    if(dataId >0){
                      var cek_nama_from_tr;
                      var cek_tgl_from_tr;
                      $.each($('#tbody_tersangka tr'),function(i,x){
                      var nama_dari_tr = $(x).find('input[type="hidden"][name="MsTersangkaDb[nama][]"]').val();
                      var tgl_dari_tr = $(x).find('input[type="hidden"][name="MsTersangkaDb[tgl_lahir][]"]').val();
                      var tgl_t = data.tgl_lahir.split('-');
                      tgl_t     = tgl_t[2]+'-'+tgl_t[1]+'-'+tgl_t[0]
                        if(data.nama_tersangka==nama_dari_tr)
                        {
                          cek_nama_from_tr = true;
                        }
                        if(tgl_t ==tgl_dari_tr)
                        {
                          cek_tgl_from_tr = true;
                        }


                      });

                      if(cek_nama_from_tr&&cek_tgl_from_tr)
                      {
                        bootbox.dialog({
                        message: "<center>Data Tersangka Sudah Tersedia Anda Yakin Akan menambahkan ?</center>",
                        buttons:{
                                    ya : {
                                        label: "Ya",
                                        className: "btn-warning",
                                        callback: function(){
                                                    $('#pdmba4-no_urut_tersangka').val(data.no_urut);
                                                    $('#pdmba4-nama').val(data.nama);
                                                    $('#pdmba4-tmpt_lahir').val(data.tmpt_lahir);
                                                    if(data.tgl_lahir !=''&& data.tgl_lahir !=null)
                                                    {
                                                      var tgl_t = data.tgl_lahir.split('-');
                                                      $('#pdmba4-tgl_lahir-disp').val(tgl_t[2]+'-'+tgl_t[1]+'-'+tgl_t[0]);
                                                      $('#pdmba4-tgl_lahir').val(data.tgl_lahir);
                                                    }
                                                    else
                                                    {
                                                      $('#pdmba4-tgl_lahir-disp').val('');
                                                    }


                                                    $('#pdmba4-umur').val(data.umur);
                                                    $('#pdmba4-warganegara-text').val(data.nama_warganegara);
                                                    $('#pdmba4-warganegara').val(data.warganegara);
                                                    $('#pdmba4-id_identitas').val(data.id_identitas);
                                                    $('#pdmba4-no_identitas').val(data.no_identitas);
                                                    $('#pdmba4-id_agama').val(data.id_agama);
                                                    $('#pdmba4-alamat').val(data.alamat);
                                                    $('#pdmba4-no_hp').val(data.no_hp);
                                                    $('#pdmba4-id_pendidikan').val(data.id_pendidikan);
                                                    $('#pdmba4-pekerjaan').val(data.pekerjaan);
                                                    if(data.suku!='')
                                                    {
                                                       $('#pdmba4-suku').val(data.suku);
                                                    }
                                                    else
                                                    {
                                                       $('#pdmba4-suku').val('-');
                                                    }
                                                    $('input:radio[name="PdmBa4[id_jkl]"][value="'+data.id_jkl+'"]').attr('checked',true);
                                                    //$('#pdmba4-suku').val(localStorage.suku_tersangka);
                                                     /*$.each($('input[type="radio"]'),function(x,y){
                                                          if(data.id_jkl==$(this).val())
                                                          {
                                                             $(this).prop('checked',true);
                                                          }
                                                      });*/
                                                     $('#m_tersangka').modal('hide');
                                        }
                                    },
                                    tidak : {
                                        label: "Tidak",
                                        className: "btn-warning",
                                        // callback: function(result){
                                        //     $('#pdmspdp-tgl_kejadian_perkara-disp').focus();
                                        // }
                                    }
                                }
                            });
                      }
                      else {
                            $('#pdmba4-no_urut_tersangka').val(data.no_urut);
                            $('#pdmba4-nama').val(data.nama);
                            $('#pdmba4-tmpt_lahir').val(data.tmpt_lahir);
                            if(data.tgl_lahir !=''&& data.tgl_lahir !=null)
                            {
                              var tgl_t = data.tgl_lahir.split('-');
                              $('#pdmba4-tgl_lahir-disp').val(tgl_t[2]+'-'+tgl_t[1]+'-'+tgl_t[0]);
                              $('#pdmba4-tgl_lahir').val(data.tgl_lahir);
                            }
                            else
                            {
                              $('#pdmba4-tgl_lahir-disp').val('');
                            }


                            $('#pdmba4-umur').val(data.umur);
                            $('#pdmba4-warganegara-text').val(data.nama_warganegara);
                            $('#pdmba4-warganegara').val(data.warganegara);
                            $('#pdmba4-id_identitas').val(data.id_identitas);
                            $('#pdmba4-no_identitas').val(data.no_identitas);
                            $('#pdmba4-id_agama').val(data.id_agama);
                            $('#pdmba4-alamat').val(data.alamat);
                            $('#pdmba4-no_hp').val(data.no_hp);
                            $('#pdmba4-id_pendidikan').val(data.id_pendidikan);
                            $('#pdmba4-pekerjaan').val(data.pekerjaan);
                            if(data.suku!='')
                            {
                               $('#pdmba4-suku').val(data.suku);
                            }
                            else
                            {
                               $('#pdmba4-suku').val('-');
                            }

                            //$('#pdmba4-suku').val(localStorage.suku_tersangka);
                            /* $.each($('input[type="radio"]'),function(x,y)
                              {
                                  if(data.id_jkl==$(this).val())
                                  {
                                     $(this).prop('checked',true);
                                  }
                              });*/
                             $('input:radio[name="PdmBa4[id_jkl]"][value="'+data.id_jkl+'"]').attr('checked',true);
                             $('#m_tersangka').modal('hide');

                      }

                    }

                });
     });

//Edit Layout Etrio Widodo
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>
