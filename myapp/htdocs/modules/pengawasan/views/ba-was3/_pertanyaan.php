    
	<?php $this->registerJs("
    $(document).ready(function(){

    $('#addpertanyaan').click(function(){
	
        $('.for_pertanyaan').append('<div class=\"col-md-12\"  style=\"margin-bottom:20px;\"><div class=\"col-sm-1\" style=\"text-align:center\"><input type=\"checkbox\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-1\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\"  size=\"1\" readonly></div><div class=\"col-sm-5\"><textarea class=\"form-control\" id=\"pertanyaan\" name=\"pertanyaan[]\" ></textarea></div><div class=\"col-sm-5\"><textarea class=\"form-control\" id=\"jawaban\" name=\"jawaban[]\" ></textarea></div></div>');
        i = 0;
    $('.for_pertanyaan').find('.col-md-12').each(function () {
        i++;
        $(this).addClass('pertanyaan'+i);
        $(this).find('.cekbok').val(i);
    });	
    });
	
    $('#hapus_pertanyaan').click(function(){
        var cek = $('.cekbok:checked').length;
         var checkValues = $('.cekbok:checked').map(function()
            {
                return $(this).val();
            }).get();
                for (var i = 0; i < cek; i++) {
                    $('.pertanyaan'+checkValues[i]).remove();
                };
                 });      

 $('#simpan-pertanyaan').click(function(){
   var jml=$('.cekbok').length;
   var pertanyaanPop= $('#pertanyaan').val();  
   var jawabanPop= $('#jawaban').val();
   //var html = '<tr><td class=\"no\"><td><input type=\"hidden\" name=\"pertanyaan[]\" value='+pertanyaanPop+'> '+pertanyaanPop+' <td> '+jawabanPop+' <input type=\"hidden\" name=\"jawaban[]\" value='+jawabanPop+'></tr>';
			var i=1;
			for (var r = 0; r < jml; r++) {
            $('#tbody_pertanyaan').append('<tr><td class=\"no\"><td><input type=\"hidden\" name=\"pertanyaan[]\" value='+pertanyaanPop+' class=\"form-control\"> '+pertanyaanPop+' <td> '+jawabanPop+' <input type=\"hidden\" name=\"jawaban[]\" value='+jawabanPop+' class=\"form-control\"></tr>');
				};
			
        $('#modal_pertanyaan').modal('hide');
                 });  	

}); ", \yii\web\View::POS_END);
?>
	<div class="col-md-12">
  

        <!-- <div class="col-md-12" style="margin-bottom:10px;"> -->
        <div class="col-sm-12" style="margin-bottom: 15px">
            <div class="col-sm-6">
        <a class="btn btn-primary" id="hapus_pertanyaan"><span class="glyphicon glyphicon-trash"><i></i></span></a>
        <a class="btn btn-primary"  id="addpertanyaan" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span> Pertanyaan</a>
            </div>
         </div>
		 <div class="col-sm-12" style="margin-bottom: 15px">
         <label class="control-label col-md-7" style="padding-left:17%;">PERTANYAAN</label>
		 <label class="control-label col-md-5">JAWABAN</label>
         </div>
        </div>
        <div class="for_pertanyaan">
		      <?php 
        if(!$model->isNewRecord){
          
            $no=1;
            foreach ($modelPertanyaan as $key) {
        ?>
              <div class="col-md-12 <?php echo"pertanyaan".$key['id_ba_was3']; ?>"  style="margin-bottom:20px;">
                  <div class="col-sm-1" style="text-align:center">
                     <input type="checkbox" value="" id="cekbok" class="cekbok">
                  </div>
                  <div class="col-sm-1">
                      <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no ?>" size="1" readonly>
                  </div>
                  <div class="col-sm-5">
                      <textarea class="form-control" id="pertanyaan" name="pertanyaan2[]" ><?php echo $key ['pertanyaan'];?></textarea>
                  </div>
				   <div class="col-sm-5">
                      <textarea class="form-control" id="jawaban" name="jawaban2[]" ><?php echo $key ['jawaban'];?></textarea>
                  </div>
              </div>
              <?php
               $no++;
			   }
            }else{ 
              ?>
			  
			  <div class="col-md-12 <?php //echo"pertanyaan".$key['id_tembusan_was']; ?>"  style="margin-bottom:20px;">
                  <div class="col-sm-1" style="text-align:center">
                     <input type="checkbox" value="" id="cekbok" class="cekbok">
                  </div>
                  <div class="col-sm-1">
                      <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly>
                  </div>
                  <div class="col-sm-5">
                      <textarea class="form-control" id="pertanyaan" name="pertanyaan2[]" ></textarea>
                  </div>
				   <div class="col-sm-5">
                      <textarea class="form-control" id="jawaban" name="jawaban2[]" ><?php// echo $key ?></textarea>
                  </div>
              </div>
              <?php
               $no_2++;
                }
              ?>
			  
    </div>
  
     <div class="col-md-12"  style="padding-left:80%; margin-bottom:2%;"> 
                <a class="btn btn-primary" id="simpan-pertanyaan">Simpan</a> 
 
         <a class="btn btn-primary" id="batal-pertanyaan">Batal</a>      
    </div>

</div>
<script type="text/javascript">
$('#batal-pertanyaan').on('click',function(){
        localStorage.clear();
        $('#modal_pertanyaan').modal('hide');
    });

	

</script>