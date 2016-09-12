;; This buffer is for notes you don't want to save, and for Lisp evaluation.
;; If you want to create a file, visit that file with C-x C-f,
;; then enter the text in that file's own buffer.


./configure --add-module=../nginx-rtmp-module --with-http_secure_link_module --with-http_ssl_module

make

sudo make install
