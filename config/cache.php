<?php
return ['default'=>env('CACHE_STORE','database'),'stores'=>['database'=>['driver'=>'database','connection'=>env('DB_CONNECTION','mysql'),'table'=>'cache','lock_connection'=>null,'lock_table'=>'cache_locks'],'array'=>['driver'=>'array','serialize'=>false]],'prefix'=>env('CACHE_PREFIX','furshield_cache')];
