fpm:
	docker run --name zalora_fpmphalcon -v /Users/nghinguyen/Code/Zalora/first_zalora_project/backend:/var/www/zalora.testproject.onl/backend --network -d zalora chrismoffatt/phalcon5-php8:latest
nginx:
	docker run --name zalora_nginx -v /Users/nghinguyen/Code/Zalora/first_zalora_project/backend:/var/www/zalora.testproject.onl/backend -v /Users/nghinguyen/Code/Zalora/first_zalora_project/backend/config/nginx.conf:/etc/nginx/conf.d/zalora.conf -p 8081:80 --network zalora nginx:1.23.4
mysql-db:
	docker run --name zalora_mysql -e MYSQL_ROOT_PASSWORD=Hoang2002 -e MYSQL_DATABASE=zalora-db -v /Users/nghinguyen/Code/Zalora/first_zalora_project/backend/mysql:/zalora/mysql --network zalora -d mysql:8.0-debian
PHONY:
	fpm nginx mysql