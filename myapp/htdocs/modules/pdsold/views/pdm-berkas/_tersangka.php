<!--<div class="modal-content modalContent" style="width: 750px;margin-left: 400px;margin-top: 30px">-->

<div class="modal-content" style="width: 500px;margin: 30px auto;">    
    <div class="modal-header">
        Data Tersangka
        <!--<a class="close" data-dismiss="modal" style="color: white">&times;</a>-->
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
                     'label' => 'Id Tersangka',
                     'attribute' => 'id_tersangka',
					 //hidden ID tersangka by Danar 20-06-2016
					 'hidden' =>true,
                    ],
                    [
                      'label' => 'Nama',
                      'attribute' => 'nama',
                    ],
               
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{select}',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::checkbox('pilih', false, ['value' => $model['id_tersangka'].'#'.$model['nama'].'#'.$model['id_tersangka']]);
                            },
                        ]
                    ],
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
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="modal-footer">
            <a id="pilih-tersangka" class="btn btn-warning">Pilih</a>
            <a id="" data-dismiss="modal" class="btn btn-danger">Batal</a><!--jaka | tambah tomol batal-->
    </div>

    </div>
<?php
$this->registerJs(\yii\web\View::POS_BEGIN);

        $js = <<< JS
	
        $('#pilih-tersangka').click(function () {
            
            $('input:checkbox:checked').each(function (index) {
                var value = $(this).val();
                var data = value.split('#');
                var trCount = $("#table_tersangka tr").length;
				var trCount2 = $("#table_riwayat tr").length;
                var idTersangkaValue = [];
                $("input[name='id_tersangka[]']").each(function(){
                    idTersangkaValue.push($(this).val());
                });
					   var popoValue = [];
                $("input[name='popoValue[]']").each(function(){
                    popoValue.push($(this).val());
                });			
                if(jQuery.inArray(data[4], idTersangkaValue) > -1) {
                    console.log(idTersangkaValue);
                    console.log(data[4]);
                    $('input:checkbox').prop('checked', false);
                    alert(data[1] + ' Sudah terpilih');return false;
                }else{
					
                    $('#tbody_tersangka').append(
                        '<tr data-id="'+data[0]+'">' +
                        '<td id="tdTRS" width="20px"><input type="checkbox" name="tersangka[]"" class="hapusTersangka" id="hapusTersangka" value="'+data[0]+'">' +
                       '<input type="text" class="hide" id="id_tersangka" name="id_tersangka[]" value="' + data[0] + '">' +
                        '<input type="hidden" name="no_urut[]" style="width: 50px;" class="form-control" value="'+(trCount)+'">' +

                        '<td><input type="text" class="form-control" name="nama_tersangka[]" readonly="true" value="' + data[1] + '"> </td>' +
						   
					  
                        '</tr>'
                    );
		$('#tbody_riwayat').append(
		 '<tr data-id="'+data[0]+'">' +
 '<tr><input type="text" id="id_tersangka" name="id_tersangka[]" value="' + data[0] + '"></tr>' +
'<td> <div class="well well-sm col-md-12"><label class="col-md-2" id="'+data[0]+'" style="padding-top:8px;padding-left:2px;font-size:16px;">'+(trCount +1)+'. '+data[1]+'</label>' +

'<div class="form-inline col-md-10" style="padding:0;"> <div class="col-md-3" style="padding-left:0;">'+
										
'<select class="form-control col-md-12" id="PdmTahananPenyidik" name="loktah['+(trCount-1)+']" id="lokasi-tahanan-selector-" style="width:100%"><option value="1">Rutan</option><option value="2">Rumah</option><option value="3">Kota</option><option value="4">Tidak Ditahan</option></select>'+

'</div><div class="col-md-5" id="startEndDate" style="padding:0 0 0 24px;">'+
  

'<input type="text"  id="tgl-mulai-'+(trCount-1)+'" class="form-control col-md-2" data-provide="datepicker" name="tglmulai['+(trCount-1)+']" value="" placeholder="Tanggal Mulai" style="width:40%">'+

'<label class="" style="margin-top: 6px;"> s.d. </label>'+

'<input type="text"   id="tgl-selesai-'+(trCount-1)+'" class="form-control" data-provide="datepicker" name="tglselesai['+(trCount-1)+']" value="" placeholder="Tanggal Selesai" style="width:143px;">'+

'</div><div class="col-md-3" id="lokasi-"  style="padding:0px 0px 0px 7px;"><input class="lokasi-rutan form-control" name="lokasi['+(trCount-1)+']" placeholder="Lokasi" style="width:184px;" value="" style="width:10px;"></div>'+
									
'<div class="col-md-2 hide" style="padding:0;" id="status-"><select class="form-control" style="width:120px;" name="PdmTahananPenyidik[status_perpanjangan]" id="status-perpanjangan-"><option value="">Status</option><option value="1">Disetujui</option><option value="2">Ditolak</option> </select></div><div class="col-md-1" id="lamaTahan-'+(trCount)+'" style="padding:8px 0px 0px 0px;"><input type="checkbox" id="lama-penahanan-'+(trCount-1)+'"> <span style="color:red;">20 hari</span></div></td>'+
' </div></div>'+
                        '</tr>'
          
                    );
					
					       $('#lama-penahanan-'+(trCount-1)+'').change(function(){
                            var tgl_mulai = $('#tgl-mulai-'+(trCount-1)+'').val();
                            if (tgl_mulai != null && tgl_mulai != '') {
                                if(this.checked){
                                    var str_tgl_mulai = tgl_mulai.split('-');
                                    console.log(str_tgl_mulai);
                                    var startDate = new Date(str_tgl_mulai);
                                    console.log(startDate);
                                    var the40DaysAfter = new Date(startDate).setDate(startDate.getDate() + 20);
                                    console.log(the40DaysAfter);
                                    var endDate = new Date(the40DaysAfter);
                                    console.log(endDate);

                                    function pad(number){
                                        return (number < 10) ? '0' + number : number;
                                    }

                                    var tgl_selesai_human_format = pad(endDate.getDate()) + '-' + pad(endDate.getMonth() + 1) + '-' + endDate.getFullYear();
                                    var tgl_selesai_db_format = endDate.getFullYear() + '-' + pad(endDate.getMonth() + 1) + '-' + pad(endDate.getDate());
                                    $('#tgl-selesai-'+(trCount-1)+'').val(tgl_selesai_human_format);
                                    $('#tgl-selesai-'+(trCount-1)+'-disp').val(tgl_selesai_human_format);
                                }
                            }
                        }); 
                    $('#m_tersangka').modal('hide');
                }

            });
			
			
        });

     //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->     
     function edit()
     {
         $('.close').hide();
         $('.panel-heading').hide();
         $('.kv-panel-before').hide();

         var text = $('.panel-heading').text();
         $('#daftar').html(text);
     }

     $(document).ajaxSuccess(function(){
      $('thead th').hide();
      if($('#id_tersangka-grid-filters td').length>2)
      {
      $('#id_tersangka-grid-filters td').first().remove();
      $('#id_tersangka-grid-filters td').last().remove();
      $('#id_tersangka-grid-filters td').attr('colspan',3);
      }
      
      $('#id_tersangka-grid-filters td input').attr('placeholder','Cari Tersangka'); 
      var div_label = '<div id=\'daftar\'></div>';
        $('.kv-panel-pager').append(div_label);
         edit();
     });
//Edit Layout Etrio Widodo
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>
</div>