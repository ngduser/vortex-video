
docker run --rm -it \
  --link mysql \
  -e MYSQL_ENV_MYSQL_PASSWORD="anw-pass" \
  -e MYSQL_ENV_MYSQL_ROOT_PASSWORD="anw-pass" \
  -e MYSQL_ENV_MYSQL_USER="anw" \
  mysql \
  sh -c 'exec mysql -h"$MYSQL_PORT_3306_TCP_ADDR" -P"$MYSQL_PORT_3306_TCP_PORT" -uroot -p"$MYSQL_ENV_MYSQL_ROOT_PASSWORD"'
