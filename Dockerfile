FROM php:7.4-fpm


ENV APP_DIR /var/www
ENV APPLICATION_ENV development
RUN mkdir -p $APP_DIR
WORKDIR $APP_DIR
EXPOSE 80
VOLUME $APP_DIR
CMD ["php", "-S", "0.0.0.0:80", "-t", "./public", "./public/index.php"]
