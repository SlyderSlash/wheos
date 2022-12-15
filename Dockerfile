#Deployment
FROM php:8.1-apache
RUN 
LABEL version="1.0"
LABEL description="Deployment for wheos project from the Bill Gates group ( AFPA Chartres )."
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY ./Deployment/vhosts.conf /etc/apache2/sites-enabled
RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev;

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN chmod -R 767 /root/.symfony5
  
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar dom mbstring zip gd xsl
RUN pecl install apcu && docker-php-ext-enable apcu
WORKDIR /var/www/html
RUN mkdir wheos
WORKDIR /var/www/html/wheos
COPY composer.json ./
RUN composer install --no-scripts --no-autoloader
COPY . ./
RUN composer dump-autoload --optimize && \
	composer run-script post-install-cmd
RUN echo "DATABASE_URL=mysql://root:@dbwheos:3306/wheos?serverVersion=5.7" >> .env.local
RUN echo "MAILER_DSN=smtp://contact%40devweb-chartres.me:Formai28000@mail.privateemail.com:465" >> .env.local
RUN echo "JWT_SECRET=Azer7y" >> .env.local
RUN echo "APP_ENV=dev" >> .env.local
RUN echo "APP_SECRET=e18631bc6be692881b028718ea955141" >> .env.local