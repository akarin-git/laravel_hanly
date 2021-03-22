FROM mariadb:10.3

ENV TZ=Asia/Tokyo \
    MYSQL_DATABASE=myapp-db \
    MYSQL_USER=myapp-user \
    MYSQL_PASSWORD=myappsecret \
    MYSQL_ROOT_PASSWORD=myappsecret

COPY ./my.cnf /etc/my.cnf