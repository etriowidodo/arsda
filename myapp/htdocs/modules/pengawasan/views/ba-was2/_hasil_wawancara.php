    
	<?php $this->registerJs("
    $(document).ready(function(){

    $('#addwawancara').click(function(){
	
        $('.for_wawancara').append('<div class=\"col-md-12\"  style=\"margin-bottom:20px;\"><div class=\"col-sm-1\" style=\"text-align:center\"><input type=\"checkbox\" id=\"cekbok\" class=\"cekbok\"></div><div class=\"col-sm-1\"><input type=\"text\" class=\"form-control\" id=\"no_urut\" name=\"no_urut\"  size=\"1\" readonly></div><div class=\"col-sm-10\"><textarea class=\"form-control\" id=\"wawancara\" name=\"wawancara[]\" ></textarea></div>');
        i = 0;
    $('.for_wawancara').find('.col-md-12').each(function () {
        i++;
        $(this).addClass('wawancara'+i);
        $(this).find('.cekbok').val(i);
    });	
    });
	
    $('#hapus_wawancara').click(function(){
        var cek = $('.cekbok:checked').length;
         var checkValues = $('.cekbok:checked').map(function()
            {
                return $(this).val();
            }).get();
                for (var i = 0; i < cek; i++) {
                    $('.wawancara'+checkValues[i]).remove();
                };
                 });      

 $('#simpan-wawancara').click(function(){
   var jml=$('.cekbok').length;
   //alert(jml);
   var wawancaraPop= $('#wawancara').val();  
   ///alert(wawancaraPop);
			var i=1;
			for (var r = 0; r < jml; r++) {
            $('#tbody_wawancara').append('<tr><td class=\"no\">'+ i++ +'<td><input type=\"hidden\" name=\"wawancara[]\" value='+wawancaraPop+' class=\"form-control\"> '+wawancaraPop+'<td><input type=\"checkbox\" id=\"cekbok1\" class=\"cekbok1\"></td></tr>');
				};
			
        $('#modal_hasil_wawancara').modal('hide');
                 });  	

}); ", \yii\web\View::POS_END);
?>
	<div class="col-md-12">
    <fieldset class="group-border">

        <!-- <div class="col-md-12" style="margin-bottom:10px;"> -->
        <div class="col-sm-12" style="margin-bottom: 15px">
            <div class="col-sm-6">
        <a class="btn btn-primary" id="hapus_wawancara"><span class="glyphicon glyphicon-trash"><i></i></span></a>
        <a class="btn btn-primary"  id="addwawancara" style="margin-top:0px;margin-right:3px;"><span class="glyphicon glyphicon-plus"> </span>Hasil Wawancara</a>
            </div>
         </div>
		 <div class="col-sm-12" style="margin-bottom: 15px">
         <!--label class="control-label col-md-7" style="padding-left:17%;">HASIL WAWANCARA</label-->
         </div>
        </div>
        <div class="for_wawancara">
              <div class="col-md-12 <?php //echo"pertanyaan".$key['id_tembusan_was']; ?>"  style="margin-bottom:20px;">
                  <div class="col-sm-1" style="text-align:center">
                     <input type="checkbox" value="" id="cekbok" class="cekbok">
                  </div>
                  <div class="col-sm-1">
                      <input type="text" class="form-control" id="no_urut" name="no_urut" value="<?php echo $no_2 ?>" size="1" readonly>
                  </div>
                  <div class="col-sm-10">
                      <textarea class="form-control" id="wawancara" name="wawancara2[]" ></textarea>
                  </div>
              </div>
              <?php
               $no_2++;
               // }
              ?>
    </div>
    </fieldset>
     <div class="col-md-12"  style="padding-left:80%; margin-bottom:2%;"> 
                <a class="btn btn-primary" id="simpan-wawancara">Simpan</a> 
 
         <a class="btn btn-primary" id="batal-wawancara">Batal</a>      
    </div>

</div>
<script type="text/javascript">
$('#batal-wawancara').on('click',function(){
        localStorage.clear();
        $('#modal_hasil_wawancara').modal('hide');
    });

	

</script>