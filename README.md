# docker-for-php-dev
php docker dev environement


## docker build -t app .
##  docker run --rm --name app  -it -p 80:80 -v "%cd%/public":/var/www/public app


##  docker network create -d bridge n1 
## docker run --name redis -p 6379:6379 --network n1 -d redis
## docker run --rm --name app -it -p 80:80 -v "%cd%/public":/var/www/public --link redis --network n1 app
