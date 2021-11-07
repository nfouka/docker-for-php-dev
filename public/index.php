<?php 

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
$start_time = microtime(true);
class smart {

    public function fibonacci($n,$first = 0,$second = 1)
    {
        $fib = [$first,$second];
        for($i=1;$i<$n;$i++)
        {
            $fib[] = $fib[$i]+$fib[$i-1];
        }
        return $fib;
    }
}

class uga extends smart { }

$ug = new uga() ; 
$cacheValue = $ug->fibonacci( empty($_GET['q']) ? 50:$_GET['q'] ) ; 


$client2 = RedisAdapter::createConnection(
    'redis://redis:6379',
    [
        'lazy' => false,
        'persistent' => 0,
        'persistent_id' => null,
        'tcp_keepalive' => 0,
        'timeout' => 30,
        'read_timeout' => 0,
        'retry_interval' => 0,
    ]
);


$cache = new RedisAdapter($client2);


$key = "key";


$cacheItem = $cache->getItem($key);
$cacheItem->set($cacheValue);
$cacheItem->expiresAfter(3600);
$cache->save($cacheItem);

echo phpversion();
dump($cache->getItem('key')->get() ) ; 
$end_time = microtime(true);

$execution_time = ($end_time - $start_time);
  
echo " Execution time of script = ".$execution_time." sec";

?>
