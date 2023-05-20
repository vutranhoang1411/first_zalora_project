fpm:
	docker run --name zalora_fpmphalcon -v /var/www/zalora.testproject.onl/backend:/var/www/zalora.testproject.onl/backend --network zalora chrismoffatt/phalcon5-php8:latest
nginx:
	docker run --name zalora_nginx -v /var/www/zalora.testproject.onl/backend:/var/www/zalora.testproject.onl/backend -v /var/www/zalora.testproject.onl/backend/config/zalora.testproject.onl:/etc/nginx/conf.d/zalora.conf -p 8081:80 --network zalora nginx:1.23.4
mysql:
	docker run --name zalora_mysql -e MYSQL_ROOT_PASSWORD=Hoang2002 -e MYSQL_DATABASE=zalora_db --network zalora -d mysql:8.0-debian
dbup:
	migrate -path db/migration -database "mysql://root:Hoang2002@tcp(localhost:3306)/Hoang" -verbose up
dbdown:
	migrate -path db/migration -database "mysql://root:Hoang2002@tcp(localhost:3306)/Hoang" -verbose down
PHONY:
	fpm nginx mysql dbup dbdown