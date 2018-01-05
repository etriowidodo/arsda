<?php 
header('Access-Control-Allow-Origin: *');
$data   = $_POST['data'];
$path = '../../data/pelimpahan';
if(!file_exists($path))
{
	mkdir($path, 0700);
}
$db = new PDO("pgsql:dbname=db_db2;host=localhost",'postgres', 'etriowidodo');
$data = json_decode($data);
       $call_back = array();
       $file ='';
                $complete = 0;
                    $spdp               = json_decode($data->spdp);
                    $ms_tersangka_spdp  = json_decode($data->ms_tersangka);

                         
                    foreach($spdp AS $key_2 => $val_2)
                    {
                    
                     $name_filed_spdp    = array();   
                     $content_filed_spdp = array(); 
                     foreach($spdp[$key_2] AS $key_3=>$result_spdp)
                     { 
                        $name_filed_spdp[]    = $key_3;                       
                        $content_filed_spdp[] = $result_spdp;
                     }
                        foreach($name_filed_spdp As $name)
                         {
                            $name_filed_spdp .= $name.',';

                         }
                         foreach( $content_filed_spdp AS $content)
                         {
                         	if($content=='')
                         	{
                         		$content = 'null';
                         		$content_filed_spdp .= $content.',';                            
                         	}
                         	else
                         	{
                         		$content_filed_spdp .= '\''.$content.'\',';   
                         	}
                         	
                         }
                          	$sql_spdp = 'INSERT INTO pidum.pdm_spdp '.str_replace(',)',')',str_replace('(Array','(','('.$name_filed_spdp.')')).' VALUES '.str_replace("'0')","'1')",str_replace(',)',')',str_replace('(Array','(','('.$content_filed_spdp.');')));
                            // echo 'INSERT INTO pidum.pdm_spdp '.str_replace(',)',')',str_replace('(Array','(','('.$name_filed_spdp.')')).' VALUES '.str_replace("'0')","'1')",str_replace(',)',')',str_replace('(Array','(','('.$content_filed_spdp.');<br>')));
                         // $call_back[] = $spdp[$key_2]->id_perkara; 
                        $db->prepare($sql_spdp)->execute();   
                        $cek = $db->errorInfo();
                        if($cek[1]==null||$cek[1]=='')
                        {
                            $call_back[] = $spdp[$key_2]->id_perkara;
                            $file .=$sql_spdp;
                        }
                    }
               
                if(count($ms_tersangka_spdp)>0)
                {
                   
                     foreach($ms_tersangka_spdp AS $key_3 => $val_3)
                            {

                                // foreach();
                                // echo key($val_3);
                                 $name_filed_tersangka_spdp    = array();   
                                 $content_filed_tersangka_spdp = array(); 
                                    foreach(get_object_vars($ms_tersangka_spdp[$key_3]) AS $key_3=>$result_tersangka_spdp)
                                     { 
                                        $name_filed_tersangka_spdp[]    = $key_3;                       
                                        $content_filed_tersangka_spdp[] = $result_tersangka_spdp;
                                     }
                                    foreach($name_filed_tersangka_spdp As $name_tersangka_spdp)
                                     {
                                        $name_filed_tersangka_spdp .= $name_tersangka_spdp.',';

                                     }
                                     foreach( $content_filed_tersangka_spdp AS $content_tersangka_spdp)
                                     {
                                        if($content_tersangka_spdp=='')
                                        {
                                            $content_tersangka_spdp = 'null';
                                            $content_filed_tersangka_spdp .= $content_tersangka_spdp.',';                            
                                        }
                                        else
                                        {
                                            $content_filed_tersangka_spdp .= '\''.$content_tersangka_spdp.'\',';   
                                        }
                                        
                                     }
                                        $sql_tersangka_spdp = 'INSERT INTO pidum.ms_tersangka '.str_replace(',)',')',str_replace('(Array','(','('.$name_filed_tersangka_spdp.')')).' VALUES '.str_replace("'0')","'1')",str_replace(',)',')',str_replace('(Array','(','('.$content_filed_tersangka_spdp.');')));
                                    // echo $sql_tersangka_spdp;
                                            $db->prepare($sql_tersangka_spdp)->execute();   
                                            $cek_tersangka_spdp = $db->errorInfo();
                                            if($cek_tersangka_spdp[1]==null||$cek_tersangka_spdp[1]=='')
                                            {
                                                
                                                $file .=$sql_tersangka_spdp;
                                            }
                            }
                }
                
                $data = array ('call_back'=>  json_encode($call_back) , 'count' => count($call_back));
                echo json_encode($data);
                if(count($call_back)>0)
                {
                    $name_file = $path.'/pelimpahan...'.date('Y-m-d...H.i.s').'.json';
                    file_put_contents($name_file, $file);
                }
				
?>