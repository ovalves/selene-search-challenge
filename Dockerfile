FROM phpswoole/swoole

RUN \
    docker-php-ext-install mysqli pdo pdo_mysql