
FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx

COPY nginx.conf /etc/nginx/http.d/default.conf

COPY . /var/www/html/

WORKDIR /var/www/html/

EXPOSE 80

CMD ["sh", "-c", "nginx && php-fpm"]