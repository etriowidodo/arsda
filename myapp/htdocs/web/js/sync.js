$(document).ready(function(){
var home = $(location).attr('href').split('/').pop();
if(home!='login')
{ 
	var dataJson =  {
					'check'	:'1',
					}
    	$.ajax({
            type: "POST",
            url : "/synchronize/check-db",
            data: dataJson,
            cache: false,
            success: function(finalResult) 
            {
              var result = JSON.parse(finalResult);

                  if(result.satker != '00')
                  {
                      function hmsToSecondsOnly(str) 
                      {
                          var p = str.split(':'),
                              s = 0, m = 1;

                          while (p.length > 0) {
                              s += m * parseInt(p.pop(), 10);
                              m *= 60;
                          }

                          return s;
                      }
                         var time_of_sync     = hmsToSecondsOnly(result.time_of_sync);
                         var time_for_compare = hmsToSecondsOnly(result.time_for_compare);
                         var end_compare      = ((time_of_sync-time_for_compare)*1000);
                         console.log(end_compare+'==>'+result.satker);
                         if(end_compare>=0)
                         {
                          setTimeout
                           (
                              function()
                              { 
                                 $.ajax({
                                      type: "POST",
                                      url : "/synchronize/proses-periodik",
                                      data: dataJson,
                                      cache: false,
                                      success: function(finalResult2) 
                                      {
                                         
                                          var result = JSON.parse(finalResult2);
                                          var dataJson2 =  {
                                              'data'   : result.data,
                                              'satker' : result.satker,
                                              'count'  : result.count
                                              }
                                         
                                          if(result.count==0)
                                          {
                                              alert('data kosong Tidak Ada Proses Sinkronisasi');
                                          }
                                          else
                                          {
                                              
                                               $.ajax({
                                                  type: "POST",
                                                  url : "http://10.1.0.24:90/webservice/",//ip_kejagung;
                                                  data: dataJson2,
                                                  cache: false,
                                                  success: function(finalResult2) 
                                                  {
                                                       $.ajax({                                     
                                                              url : "/synchronize/success-sync",
                                                              cache: false,
                                                              success: function(finalResult3) 
                                                              {                                          
                                                              },
                                                              error: function(finalResult3)
                                                              {
                                                              } 
                                                          });
                                                  },
                                                  error: function(finalResult2)
                                                  {
                                                  } 
                                              });
                                          }
                                      },
                                      error: function(finalResult2)
                                      {

                                      }
                                  });
                              },
                                end_compare
                            );
                         }

                  }
            
            
            },
            error :function()
            {
             
            }
        });
}


});




$(document).ready(function(){
 $('.freeze').attr('disabled','true');
 $('input[type=radio]').on('click',function(){
    if($(this).val()==2)
    {
      $('.freeze').removeAttr('disabled');  
      $('.btn-success').attr('disabled','true'); 
    }
    else
    {
      $('.freeze').attr('disabled','true');
       $('input[type=checkbox].freeze').removeAttr('checked');
       $('.btn-success').removeAttr('disabled'); 
    }
 });

 $('#proses').click(function(){
    var count =0;
   $('input[type=checkbox].freeze').each(function(x){
    if($(this).is(":checked"))
    {
        count +=1;
    }
   })
       if(count==0)
       {
        alert('Salah Satu harus tercentang ! ! !');
       }
       else
       {
            var pidum = ($('#pidum_checkbox').is(':checked'))?$('#pidum_checkbox').val():'';
            var datun = ($('#datun_checkbox').is(':checked'))?$('#datun_checkbox').val():'';
            var was   = ($('#was_checkbox').is(':checked'))?$('#was_checkbox').val():'';
            var dataJson =  {
                'pidum' :pidum,
                'datun' :datun,
                'was'   :was
                }
            $.ajax({
                type: "POST",
                url : "/synchronize/proses-insidental",
                data: dataJson,
                cache: false,
                success: function(finalResult) 
                {
                    var result = JSON.parse(finalResult);
                    var dataJson2 =  {
                        'data'   : result.data,
                        'satker' : result.satker,
                        'count'  : result.count
                        }
                   
                    if(result.count==0)
                    {
                        alert('data kosong Tidak Ada Proses Sinkronisasi');
                    }
                    else
                    {
                        
                         $.ajax({
                            type: "POST",
                            url : "http://10.1.0.24:90/webservice/", // ip kejagung
                            data: dataJson2,
                            cache: false,
                            success: function(finalResult2) 
                            {
                                 $.ajax({                                     
                                      url : "/synchronize/success-sync",
                                      cache: false,
                                      success: function(finalResult3) 
                                      {                                          
                                      },
                                      error: function(finalResult3)
                                      {
                                      } 
                                  });
                            },
                            error: function(finalResult2)
                            {
                            } 
                        });
                    }
                },
                error: function(finalResult)
                {

                }
            });

       }
 });
});


//Syncronisasi Pelimpahan
$(document).ready(function(){
      var home = $(location).attr('href').split('/').pop();
      if(home!='login'){
      var dataJson =  {
          'check' :'1',
          } 
          $.ajax({
            type: "POST",
            url : "/synchronize/check-db",
            data: dataJson,
            cache: false,
            success: function(finalResult) 
            {
              var result = JSON.parse(finalResult);
                  if(result.satker == '00')
                  {
                            var input_sync = "<input id='input_sync' type='hidden' value='1'>";
                            $('body').append(input_sync);
                            $('.notif').css('background-color','orange');
                              $('.notif').html('Aktif');
                              var count_timer = 1
                        
                            var detik =  10000;//14400000;
                            var count =     1;
                            var timer =   null;
                            var input = document.getElementById('input_sync');

                            function tick() {
                                ++input.value;
                                start();        // restart the timer
                            };

                            function start() {  // use a one-off timer
                                timer = setTimeout(tick, 1000);
                               
                                 setInterval(timesync,1000);
                                
                            };

                            function stop() {
                                clearTimeout(timer);
                                
                            };
                            start();
                            function timesync(){

                            var a       = parseInt(document.getElementById('input_sync').value);
                            var b     = detik-(a*1000); 
                            mydate=new Date(b);
                            humandate=mydate.getUTCHours()+":"+mydate.getUTCMinutes()+":"+mydate.getUTCSeconds();
                                  if(a*1000 % detik ===0 )
                                  {
                                    //console.log('berhasil');

                                     stop();
                                    for (var i = 1; i < 99999; i++)
                                    {
                                       window.clearInterval(i);
                                    }

                                    var dataJson =  {
                                              'check' :'1',
                                              }
                                    $.ajax({
                                                type: "POST",
                                                url : "/synchronize/sync-pelimpahan",
                                                data: dataJson,
                                                cache: false,
                                                global:false,
                                                success: function(finalResultPelimpahan) 
                                                {
                                                  var _finalResultPelimpahan = JSON.parse(finalResultPelimpahan);
                                                  if(_finalResultPelimpahan.count>0)
                                                  {
                                                    var _ip = JSON.parse(_finalResultPelimpahan.data);
                                                    var url = '/webservice_pelimpahan/';
                                                    $.each(_ip,function(i,x){
                                                      var dataSend = {
                                                        'data' : _ip[i]['data']
                                                      }
                                                         $.ajax({
                                                            type: "POST",
                                                            url : _ip[i]['ip']+url,
                                                            data: dataSend,
                                                            cache: false,
                                                            global:false,
                                                            success: function(finalResultPelimpahan1) 
                                                            {
                                                              var finalResultPelimpahan1 = JSON.parse(finalResultPelimpahan1);
                                                              if(finalResultPelimpahan1.count>0)
                                                              { 
                                                                 var  dataUpdate = { 'call_back' : finalResultPelimpahan1.call_back}
                                                                 $.ajax({
                                                                    type: "POST",
                                                                    url : "/synchronize/success-pelimpahan",
                                                                    data: dataUpdate,
                                                                    cache: false,
                                                                    global:false,
                                                                    success: function(updateResultPelimpahan)
                                                                    {
                                                                      console.log(updateResultPelimpahan);
                                                                    },
                                                                    error:function(updateResultPelimpahan)
                                                                    {

                                                                    }
                                                                  });

                                                              }
                                                            },
                                                            error: function(finalResultPelimpahan1){

                                                            }
                                                          });
                                                      
                                                    })
                                                  }
                                                },
                                                error:function(finalResultPelimpahan)
                                                {

                                                }
                                              });

                                    document.getElementById('input_sync').value=0;
                                    start();
                            
                            }
                      }
                  }
            }
          });

       }


});