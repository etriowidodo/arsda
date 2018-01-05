DELETE FROM menu where module='PIDUM' and (parent ='300' OR id='300');                                                                                                                                               
                                                                                                                                                                                   
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (300, 'PRA PENUNTUTAN', NULL, '', 1, NULL, 'PIDUM');                                         
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (301, 'Daftar Spdp', 300, '/pidum/spdp/index', 1, NULL, 'PIDUM');                            
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (302, 'Penerimaan SPDP', 300, '/pidum/spdp/create', 1, NULL, 'PIDUM');                       
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (303, 'P-16', 300, '/pidum/p16/update', 3, NULL, 'PIDUM');                                    
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (304, 'PerpanjanganTahanan', 300, '/pidum/pdm-perpanjangan-tahanan/update', 4, NULL, 'PIDUM');
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (305, 'T-4', 300, '/pidum/pdm-t4/index', 5, NULL, 'PIDUM');                                   
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (306, 'T-5', 300, '/pidum/pdm-t5/index', 6, NULL, 'PIDUM');                                  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (307, 'P-17', 300, '/pidum/pdm-p17/update', 7, NULL, 'PIDUM');                                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (308, 'Penerimaan Tahap I', 300, '/pidum/pdm-berkas/update', 8, NULL, 'PIDUM');              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (309, 'P-24', 300, '/pidum/pdm-p24/index', 9, NULL, 'PIDUM');                                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (310, 'P-21', 300, '/pidum/pdm-p21/update', 10, NULL, 'PIDUM');                               
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (311, 'P-21A', 300, '/pidum/pdm-p21-a/index', 11, NULL, 'PIDUM');                            
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (312, 'P-18', 300, '/pidum/pdm-p18/update', 12, NULL, 'PIDUM');                               
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (313, 'P-19', 300, '/pidum/pdm-p19/update', 13, NULL, 'PIDUM');
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (314, 'P-20', 300, '/pidum/pdm-p20/update', 14, NULL, 'PIDUM');
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (315, 'P-22', 300, '/pidum/pdm-p22/update', 15, NULL, 'PIDUM');
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (316, 'P-23', 300, '/pidum/pdm-p23/update', 16, NULL, 'PIDUM');
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (317, 'Penyelesaian Pratut', 300, '/pidum/pdm-pratut-putusan/index', 16, NULL, 'PIDUM');

DELETE FROM menu where module='PIDUM' and (parent ='321' OR id='321');  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (321, 'PENUNTUTAN', NULL, '', 2, NULL, 'PIDUM');                                             
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (322, 'Penerimaan Tahap II', 321, '/pidum/pdm-tahap-dua/index', 2, NULL, 'PIDUM');           
-- INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (323, 'Daftar Penuntutan', 321, '/pidum/penuntutan/index', 2, NULL, 'PIDUM');                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (324, 'BA-15', 321, '/pidum/pdm-ba15/index', 4, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (325, 'T-7', 321, '/pidum/pdm-t7/index', 4, NULL, 'PIDUM');                                  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (326, 'BA-10', 321, '/pidum/pdm-ba10/update', 5, NULL, 'PIDUM');                             
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (327, 'BA-11', 321, '/pidum/pdm-ba11/update', 6, NULL, 'PIDUM');                             
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (328, 'T-6', 321, '/pidum/pdm-t6/index', 7, NULL, 'PIDUM');                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (329, 'BA-6', 321, '/pidum/pdm-ba6/update', 8, NULL, 'PIDUM');                               
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (330, 'T-8', 321, '/pidum/pdm-t8/index', 9, NULL, 'PIDUM');                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (331, 'T-9', 321, '/pidum/pdm-t9/index', 11, NULL, 'PIDUM');                                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (332, 'T-10', 321, '/pidum/pdm-t10/index', 12, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (333, 'T-11', 321, '/pidum/pdm-t11/index', 13, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (334, 'T-12', 321, '/pidum/pdm-t12/index', 14, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (335, 'T-13', 321, '/pidum/pdm-t13/index', 15, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (336, 'T-14', 321, '/pidum/pdm-t14/index', 16, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (337, 'T-15', 321, '/pidum/pdm-t15/index', 17, NULL, 'PIDUM');                               
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (338, 'BA-12', 321, '/pidum/pdm-ba12/index', 8, NULL, 'PIDUM');                             
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (339, 'BA-13', 321, '/pidum/pdm-ba13/index', 9, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (340, 'BA-14', 321, '/pidum/pdm-ba14/update', 10, NULL, 'PIDUM');                            
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (341, 'BA-18', 321, '/pidum/pdm-ba18/update', 18, NULL, 'PIDUM');                             
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (342, 'P-16A', 321, '/pidum/pdm-p16a/index', 3, NULL, 'PIDUM');                            
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (343, 'P-28', 321, '/pidum/pdm-p28/update', 20, NULL, 'PIDUM');                            
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (344, 'P-7', 321, '/pidum/pdm-p7/index', 21, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (345, 'BA-5', 321, '/pidum/pdm-ba5/update', 22, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (346, 'P-13', 321, '/pidum/p13/index', 23, NULL, 'PIDUM');                               
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (347, 'P-26', 321, '/pidum/pdm-p26/update', 24, NULL, 'PIDUM');                               
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (348, 'P-29', 321, '/pidum/pdm-p29/index', 25, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (349, 'P-31', 321, '/pidum/pdm-p31/index', 26, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (350, 'P-33', 321, '/pidum/pdm-p33/index', 27, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (351, 'P-30', 321, '/pidum/pdm-p30/update', 28, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (352, 'P-32', 321, '/pidum/pdm-p32/update', 29, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (353, 'P-34', 321, '/pidum/pdm-p34/update', 30, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (354, 'P-35', 321, '/pidum/pdm-p35/index', 31, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (355, 'P-36', 321, '/pidum/pdm-p36/index', 32, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (356, 'P-37', 321, '/pidum/pdm-p37/index', 33, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (357, 'P-38', 321, '/pidum/pdm-p38/index', 34, NULL, 'PIDUM');                                                 
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (358, 'P-39', 321, NULL, 35, NULL, 'PIDUM');                                                 
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (359, 'P-41', 321, NULL, 36, NULL, 'PIDUM');                                                 
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (360, 'P-42', 321, NULL, 37, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (361, 'P-43', 321, '/pidum/pdm-p43/index', 38, NULL, 'PIDUM');
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (362, 'P-44', 321, NULL, 39, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (363, 'P-45', 321, '/pidum/pdm-p45/index', 40, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (364, 'P-25', 321, '/pidum/pdm-p25/index', 41, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (365, 'P-9', 321, '/pidum/pdm-p9/index', 42, NULL, 'PIDUM');                                                  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (366, 'BA-2', 321, '/pidum/pdm-ba2/index', 43, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (367, 'P-10', 321, '/pidum/pdm-p10/index', 44, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (368, 'BA-3', 321, '/pidum/pdm-ba3/index', 45, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (369, 'P-11', 321, '/pidum/pdm-p11/index', 46, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (370, 'BA-4', 321, '/pdm-ba4/index', 47, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (371, 'B-4', 321, '/pidum/pdm-b4/index', 48, NULL, 'PIDUM'); /* tambahan  menu */            
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (372, 'B-1', 321, '/pidum/pdm-b1/index', 49, NULL, 'PIDUM');                                                  
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (373, 'BA-16', 321, NULL, 50, NULL, 'PIDUM');                                                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (374, 'B-2', 321, '/pidum/pdm-b2/index', 51, NULL, 'PIDUM');                                                  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (375, 'B-17', 321, '/pidum/pdm-b17/index', 52, NULL, 'PIDUM');                              
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (376, 'BA-20', 321, NULL, 53, NULL, 'PIDUM');                                                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (377, 'B-7', 321, '/pidum/pdm-b7/index', 54, NULL, 'PIDUM');                                                  
--NSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (378, 'B-9', 321, NULL, 55, NULL, 'PIDUM');                                                  
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (379, 'B-10', 321, NULL, 56, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (380, 'B-11', 321, '/pidum/pdm-b11/index', 57, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (381, 'B-12', 321, '/pidum/pdm-b12/index', 58, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (382, 'B-13', 321, '/pidum/pdm-b13/index', 59, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (383, 'B-14', 321, '/pidum/pdm-b14/index', 60, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (384, 'B-15', 321, '/pidum/pdm-b15/index', 61, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (385, 'B-16', 321, '/pidum/pdm-b16/index', 62, NULL, 'PIDUM');                                                 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (386, 'B-21', 321, '/pidum/pdm-b21/index', 63, NULL, 'PIDUM');                                                 
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (387, 'BA-19', 321, NULL, 64, NULL, 'PIDUM');                                                
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (388, 'B-22', 321, '/pidum/pdm-b22/index', 65, NULL, 'PIDUM'); 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (389, 'Penetapan Hakim', 321, '/pidum/pdm-tetap-hakim/index', 52, NULL, 'PIDUM');


--- UPAYA HUKUM
DELETE FROM menu where module='PIDUM' and (parent ='430' OR id='430');  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (430, 'UPAYA HUKUM', NULL, '', 3, NULL, 'PIDUM');     
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (431, 'P-46', 430, '/pidum/pdm-p46/index', 2, NULL, 'PIDUM');        
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (432, 'P-47', 430, '/pidum/pdm-p47/index', 3, NULL, 'PIDUM');        
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (433, 'P-50', 430, '/pidum/pdm-p50/index', 4, NULL, 'PIDUM');        
--INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (434, 'P-48', 430, '/pidum/pdm-p48/update', 5, NULL, 'PIDUM');        
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (435, 'BA-8', 430, '/pidum/pdm-ba8/index', 6, NULL, 'PIDUM');        
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (436, 'BA-20', 430, '/pidum/pdm-ba20/index', 7, NULL, 'PIDUM');
 

  
  
--- EKSEKUSI 
DELETE FROM menu where module='PIDUM' and (parent ='460' OR id='460');  
INSERT INTO menu ("id", "name", "parent", "route", "order", "data", "module") VALUES (460, 'EKSEKUSI', NULL, '', 4, NULL, 'PIDUM');     
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (463,'P-49',460,'/pidum/pdm-p49/update',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (464,'P-51',460,'/pidum/pdm-p51/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (465,'P-52',460,'/pidum/pdm-p52/index',4,NULL,'PIDUM');
-- insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (466,'RP-12',460,'/pidum/pdm-p/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (467,'BA-9',460,'/pidum/pdm-ba9/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (468,'B-19',460,'/pidum/pdm-b19/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (469,'BA-20',460,'/pidum/pdm-ba20/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (470,'BA-21',460,'/pidum/pdm-ba21/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (471,'BA-22',460,'/pidum/pdm-ba22/index',4,NULL,'PIDUM');
-- insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (472,'BA-8',460,'/pidum/pdm-ba8/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (473,'B-20',460,'/pidum/pdm-b20/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (474,'B-21',460,'/pidum/pdm-b21/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (475,'B-22',460,'/pidum/pdm-b22/index',4,NULL,'PIDUM');
--insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (476,'BA-23',460,'/pidum/pdm-p/index',4,NULL,'PIDUM');
--insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (477,'B-18',460,'/pidum/pdm-p/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (478,'D1',460,'/pidum/pdm-d/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (479,'D2',460,'/pidum/pdm-d2/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (480,'D3',460,'/pidum/pdm-d3/index',4,NULL,'PIDUM');
--insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (481,'D4',460,'/pidum/pdm-p/index',4,NULL,'PIDUM');



      

-- LAPORAN
DELETE FROM menu where module='PIDUM' and (parent ='500' OR id='500');  
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (500, 'LAPORAN', NULL, '', 5, NULL, 'PIDUM');       
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (501, 'LP-4',500 , '/pidum/pdm-lp4', 5, NULL, 'PIDUM');   
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (502, 'LP-4A',500 , '/pidum/pdm-lp4a', 5, NULL, 'PIDUM');    
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (503, 'LP-6',500 , '/pidum/pdm-lp6', 5, NULL, 'PIDUM');    
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (504, 'LP-7',500 , '/pidum/pdm-lp7', 5, NULL, 'PIDUM'); 
   
 
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (505,'P-48',460,'/pidum/pdm-p48/update',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (506,'BA-8',460,'/pidum/pdm-ba8/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (507,'BA-20',460,'/pidum/pdm-ba20/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (508,'P-49',460,'/pidum/pdm-p49/update',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (509,'P-40',460,'/pidum/pdm-p40/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (510,'P-44',460,'/pidum/pdm-p44/create',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (511,'BA-16',460,'/pidum/pdm-ba16/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (512,'BA-17',460,'/pidum/pdm-ba17/index',4,NULL,'PIDUM');
insert into menu ("id", "name", "parent", "route", "order", "data", "module") values (513,'BA-19',460,'/pidum/pdm-ba19/index',4,NULL,'PIDUM');


  

                                         
