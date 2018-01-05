/**
 * Created by rio on 06/04/15.
 */


$(document).ready(function(){
    $("a.kv-toggle").on("click",function(){
            // console.log(e);
            $(this).parents().removeClass('active');
           // console.log(e.target.href);
           // console.log($(this).parent());
            // e.preventDefault();
            // $.ajax({
            //     type: "GET",
            //     url: e.target.href,
            //     data: 'backup=true',
            //     success:function(data){
            //         $('body').html(data);
            //         $("li").toggleClass('active');
            //     }
            // });
            /*$('body').load(e.target.href);

            $(this).parent().toggleClass('active');
            $(this).parent().children('ul').toggle();
            e.stopPropagation();

            $.ajax()*/

            //$(this).parent().toggleClass('active');
            //$(this).parent().children('ul').toggle();
            //$(this).parent().toggleClass('active');
            /*localStorage.setItem('last', $(this).parent().toggleClass('active'));
            var last = localStorage.getItem('last');
            if (last) {
                $('body').load(e.target.href);
                $(this).parent().toggleClass('active');
            }*/
        });
});


/**
* fungsi js untuk hapus data grid dan mengeluarkan konfirmasi dialog
* 1. gunakan class checkHapus pada input checkbox
* 2. gunakan class btnHapus Checkbox pada a element class hapus
* 3. gunakan element data-id={value} pada tr element
 */
$( document ).on('click', '.checkHapus', function(e) {
    var data_id = $(this).closest('tr').data('id');
    var input = $( this );
    $(".btnHapusCheckbox").click(function(){
        if(input.prop( "checked" ) == true){
            bootbox.dialog({
                message: "Apakah anda ingin menghapus data ini?",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-warning",
                        callback: function(){
                            $('tr[data-id="'+data_id+'"]').remove();
                            $(".btnHapusCheckbox").off("click");
                        }
                    },
                    tidak : {
                        label: "Tidak",
                        className: "btn-warning",
                        callback: function(result){
                            $(".btnHapusCheckbox").off("click");
                        }
                    }
                }
            });

        }else if(input.prop( "checked" ) == false){
            $(".btnHapusCheckbox").off("click");
        }
    });


});


/**
 * Digunakan untuk grid spdp
 */

$(document).ready(function(){
    $('.btnHapusCheckboxIndex').attr('disabled',true);
	$('.btnUbahCheckboxIndex').attr('disabled', true);
	$('.btnPrintCheckboxIndex').attr('disabled', true);
});

$( document ).on('click', '.checkHapusIndex', function(e) {
    var input = $( this );
    var total_checked = $(".checkHapusIndex:checkbox:checked").length;

    if(total_checked < 1){
        $(".btnHapusCheckboxIndex").attr("disabled", true);
		$(".btnUbahCheckboxIndex").attr("disabled", true);
		$(".btnPrintCheckboxIndex").attr("disabled", true);
    }

    if(input.prop( "checked" ) == true){
        $(".btnHapusCheckboxIndex").attr("disabled",false);
		$(".btnUbahCheckboxIndex").attr("disabled", false);
		$(".btnPrintCheckboxIndex").attr("disabled", false);
		ref = e.target.value;
		ref = ref.replace("/","");
        $('#divHapus').append(
            "<input type='hidden' id='hapus-"+ref+"' name='hapusIndex[]' value='"+e.target.value+"'>"
        );
    }else{
        //$('#hapus').remove();
		ref = e.target.value;
		ref = ref.replace("/","");
        $('#hapus-'+ref).remove();

    }

});

$("input[name='selection_all']").change(function(){
    var selectAll = $(this);

    if(selectAll.prop("checked") == true){
        $(".btnHapusCheckboxIndex").attr("disabled", false);
		$(".btnUbahCheckboxIndex").attr("disabled", false);
		$(".btnPrintCheckboxIndex").attr("disabled", false);
        $("input[name='hapusIndex[]']").detach();
        $('#divHapus').append(
            "<input type='hidden' id='hapus' name='hapusIndex[]' value='all'>"
        );
    }else{
        $(".btnHapusCheckboxIndex").attr("disabled", true);
		$(".btnUbahCheckboxIndex").attr("disabled", true);
		$(".btnPrintCheckboxIndex").attr("disabled", true);
        $("input[name='hapusIndex']").remove();
    }
});

$(".btnHapusCheckboxIndex").click(function(e){

    e.preventDefault();

	var arr = [];
	var cek = '';
	$('.checkHapusIndex:checked').each(function(x){
		if($(this).attr('nilai')!='SPDP'){
			cek = '1';
		}
		if(typeof $(this).attr('nilai')=='undefined'){
			cek = '2';
		}
		//arr.push($(this).attr('nilai'));
	});



	if (cek == '1' )
	{
	 bootbox.dialog({
			message: "Data Perkara Sudah Melebihi Tahap SPDP",
			buttons:{
				ya : {
					label: "OK",
					className: "btn-warning",

				}
			}
		});
	}else{
		var id =$('.checkHapusIndex:checked').data('id');

		if(id=='0'){
			bootbox.dialog({
                message: "Data Persuratan Belum Diinput",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}else{
			bootbox.dialog({
				message: "Apakah anda ingin menghapus data ini??",
				buttons:{
					ya : {
						label: "Ya",
						className: "btn-warning",
						callback: function(){
              var ts = 0;
              $('.checkHapusIndex:checked').each(function(x){
            		var tr_id = $(this).parent().parent().data('id');
                if($('tr[data-id="'+tr_id+'"] td:eq(4)').text()!='')
                {
                  ++ts;
                }

                //console.log($("tr[data-id='+tr_id+'] td:eq(5)").text());
            	});

            if(ts>0)
            {
              bootbox.dialog({
                        message: "Hapus Terlebih dahulu tersangkanya",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",

                            }
                        }
                    });
            }
            else {
              $('#hapus-index').submit();
  						$(".btnHapusCheckboxIndex").off("click");
            }



						}
					},
					tidak : {
						label: "Tidak",
						className: "btn-warning",
						callback: function(result){
							// $(".btnHapusCheckboxIndex").off("click");
						}
					}
				}
			});
		}
	}
});



function stopRKey(evt) {
    var evt = (evt) ? evt : ((event) ? event : null);
    var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}

document.onkeypress = stopRKey;
