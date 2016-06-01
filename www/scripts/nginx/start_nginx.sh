#!/bin/bash

docker stop nginx; docker rm nginx;

docker run -d \
  --name nginx \
  --net=host \
  -v /home/ec2-user/VideoSite/public:/usr/share/nginx/html:ro \
  -v $(pwd)/nginx.conf:/etc/nginx/nginx.conf:ro \
  nginx
