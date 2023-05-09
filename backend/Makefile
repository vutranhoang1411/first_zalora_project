fpm:
	docker run --name zalora_fpmphalcon -v /var/www/zalora.testproject.onl/html:/var/www/zalora.testproject.onl/html --network zalora chrismoffatt/phalcon5-php8:latest
nginx:
	docker run --name zalora_nginx -v /var/www/zalora.testproject.onl/html:/var/www/zalora.testproject.onl/html -v /var/www/zalora.testproject.onl/html/config/zalora.testproject.onl:/etc/nginx/conf.d/zalora.conf -p 8081:80 --network zalora nginx:1.23.4
mysql:
	docker run --name zalora_mysql -e MYSQL_ROOT_PASSWORD=Hoang2002 -e MYSQL_DATABASE=Hoang --network zalora mysql:8.0-debian
PHONY:
	fpm nginx mysql