php-redis-dump
==============

redis dump/restore tool

Usage:
======

```
php redis-dump.php -s /tmp/redis.sock -n 2 > dump.r
php redis-restore.php -h remote-redis.org -p 6379 -n 2 < dump.r
```
