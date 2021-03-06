<?php

if (!extension_loaded('redis')) {
    die("redis extension not loaded\n");
};

set_time_limit(0);

$opt = getopt('h:p:s:n:');

$host = isset($opt['h']) ? $opt['h'] : '127.0.0.1';
$port = isset($opt['p']) ? $opt['p'] : 6379;
$socket = isset($opt['s']) ? $opt['s'] : null;
$dbnum = isset($opt['n']) ? $opt['n'] : 0;

$redis = new Redis();

try {
    $socket && $redis->connect($socket) || $redis->connect($host, $port);
    $redis->select($dbnum);
} catch (Exception $e) {
    die("cannot connect to redis\n");
};

foreach ($redis->keys('*') as $key) {
    $ttl = $redis->ttl($key);
    $value = bin2hex($redis->dump($key));
    printf("%s %d %s\n", $key, $ttl > 0 ? ($ttl*1000) : 0, $value);
};

$redis->close();
