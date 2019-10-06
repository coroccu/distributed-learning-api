FROM amazonlinux:latest

RUN amazon-linux-extras install -y php7.3=7.3.4 epel
RUN yum install -y spawn-fcgi php-mbstring zip unzip

#Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

#Xdebug
RUN yum install php-pear php-devel gcc make -y
RUN pecl install xdebug

COPY php.ini /etc/php.ini