FROM debian:stretch

MAINTAINER mgpapelaria.com.br

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install --reinstall systemd -y \
    && apt-get install -y \
    lsb-release \
    apt-transport-https \
    wget \
    nginx \
    vim \
    rsync \
    curl \
    && systemctl enable nginx
    
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' \
    && apt update
    
RUN apt install -y \
    php5.6-cli \
    php5.6-fpm \
    php5.6-pgsql \
    php5.6-gd \
    php5.6-soap \
    php5.6-curl \
    php5.6-mbstring \
    php5.6-xml
    
#RUN apt install -y memcached \
#    php-pear \
#    composer \
#    pkg-config \
#    zlib1g-dev \
#    libmemcached-dev \
#    && pecl install memcached

RUN mv /var/www/html/index.nginx-debian.html /var/www/html/index.html
    
COPY config/php/php.ini /etc/php/5.6/fpm/php.ini
COPY config/nginx/default.conf /etc/nginx/sites-available/default

#RUN mkdir /opt/www && mkdir /opt/www/MGsis && mkdir /opt/www/MGsis/yii-1.1.14.f0fee9/
#RUN cd /opt/www/
#RUN ln -s MGsis/yii-1.1.14.f0fee9/ /opt/yii-1.1.14.f0fee9

#RUN mkdir /opt/www/
#COPY config/yii-1.1.14.f0fee9 /opt

CMD service nginx start \
    && service php5.6-fpm start \
    && /bin/bash
    #&& service memcached start \
    #&& /bin/bash
