#!/bin/sh

# Builds FUSE for s3fs

sudo apt-get install build-essential git libfuse-dev libcurl4-openssl-dev libxml2-dev mime-support automake libtool
sudo apt-get install pkg-config libssl-dev
git clone https://github.com/s3fs-fuse/s3fs-fuse
cd s3fs-fuse/
./autogen.sh
./configure --prefix=/usr --with-openssl
make
sudo make install

# Prepare directories

mkdir /tmp/cache
chmod 777 /tmp/cache
mkdir /srv/s3mnt 

# Mount command won't work without AWS Credential file set up
 
s3fs -o use_cache=/tmp/cache vortex-bucket /srv/s3mnt


