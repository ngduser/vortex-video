#!/bin/bash

docker run --rm -it \
  --link mongo \
  mongo \
  sh -c 'exec mongo "$MONGO_PORT_27017_TCP_ADDR:$MONGO_PORT_27017_TCP_PORT/test"'
