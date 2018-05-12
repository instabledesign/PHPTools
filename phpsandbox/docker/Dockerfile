FROM nginx:latest

# Update Repository
RUN apt-get update

# Add packages.sury.org (contains PHP packages)
RUN apt-get -y install apt-transport-https lsb-release ca-certificates
RUN apt-get install wget
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'

# Update Repository with PHP packages
RUN apt-get update

# Install all php version and supervisor
RUN apt-get install -y \
    php5.6-fpm \
    php7.0-fpm \
    php7.1-fpm \
    php7.2-fpm \
    supervisor

# Copy all config files
COPY files /tmp/
RUN cp -R /tmp/etc/* /etc/ && rm -rf /tmp/etc
RUN mkdir /run/php

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf", "-n"]
