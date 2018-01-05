
DELETE FROM menu where module='PIDUM' and (parent ='600' OR id='600'); 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (600, 'MASTER', NULL, '', 1, NULL, 'PIDUM'); 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (601, 'Asal Surat', 600, '/pidum/asal-surat/index', 1, NULL, 'PIDUM');           
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (602, 'Penyidik', 600, '/pidum/penyidik/index', 1, NULL, 'PIDUM'); 
INSERT INTO menu  ("id", "name", "parent", "route", "order", "data", "module") VALUES (603, 'Penanda Tangan', 600, '/pidum/pdm-penandatangan/index', 1, NULL, 'PIDUM');           


-- C:/Program Files/PostgreSQL/9.4/bin\pg_dump.exe --host 10.1.6.6 --port 5432 --username "postgres" --no-password  --format custom --verbose --file "C:\Users\User\Desktop\pidsus.backup" --schema "pidsus" "simkari_cms"