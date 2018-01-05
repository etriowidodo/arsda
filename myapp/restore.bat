CD c:\     
cd c:\myapp\db\App\PgSQL\bin
pg_restore --host=localhost  --port=411 --username=postgres  -v --dbname=simkari_cms -C -O --superuser=postgres --disable-triggers %1