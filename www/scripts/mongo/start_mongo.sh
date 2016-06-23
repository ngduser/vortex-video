#!/bin/bash

docker run -d \
  --name mongo \
  -p 27017:27017 \
  -v $(pwd)/data:/data/db \
  mongo:latest
