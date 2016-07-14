docker stop mysql 2> /dev/null
docker rm mysql 2> /dev/null

docker run -d \
  --name mysql \
  -v $(pwd)/data:/var/lib/mysql \
  -v $(pwd)/user_accounts.sql:/docker-entrypoint-initdb.d/user_accounts.sql \
  -e MYSQL_ROOT_PASSWORD=anw-pass \
  -e MYSQL_USER=anw \
  -e MYSQL_PASSWORD=anw-pass \
  -e MYSQL_DATABASE=vigilant-video \
  mysql:latest
