FROM nginx
 
RUN chmod -R 777 /etc/nginx/*

COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY ./certs/nginx.crt /etc/nginx/certs
COPY ./certs/nginx.key /etc/nginx/certs

EXPOSE 80:443
ENTRYPOINT nginx -g 'daemon off;'