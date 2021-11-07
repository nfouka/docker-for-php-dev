<?php 

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;

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
$cacheValue = $ug->fibonacci(100) ; 


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

dump($cache->getItem('key')->get() ) ; 


?>
