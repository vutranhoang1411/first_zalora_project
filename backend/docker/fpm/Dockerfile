from chrismoffatt/phalcon5-php8:latest
COPY . /var/www/zalora.testproject.onl/backend/ 
RUN curl -L https://github.com/golang-migrate/migrate/releases/download/v4.15.2/migrate.linux-amd64.tar.gz | tar xvz
RUN mv migrate /migrate
ENTRYPOINT ["/var/www/zalora.testproject.onl/backend/start.sh"]
CMD ["php-fpm","-F","-R"]