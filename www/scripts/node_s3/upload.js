var AWS = require('aws-sdk');
AWS.config.region = 'us-east-1';

var fs = require('fs');

if (process.argv.length < 3) {
  console.log("Requires a filename as a command-line argument");
  process.exit(1);
}

var body = fs.createReadStream(process.argv[2]);
var s3obj = new AWS.S3({params: {Bucket: 'umuc.cmsc495.vigilant-video', Key: process.argv[2]}});
s3obj.upload({Body: body}).
  on('httpUploadProgress', function(evt) { console.log(evt); }).
    send(function(err, data) { console.log(err, data) });
