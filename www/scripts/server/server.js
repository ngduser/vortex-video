var express = require('express');
var app = express();

var mongoose = require('mongoose');
mongoose.connect('mongodb://localhost/test');

const videoSchema = {
  title: String,
  url: String,
  desc: String,
};

var Video = mongoose.model('Video', videoSchema);

app.get('/featured', (req, res) => {
  Video.find( (err, videos) => {
    if (err) return console.error(err);
    console.log(videos);
    res.json(videos);
  });
});

app.get('/popular', (req, res) => {
  res.send('popular videos');
});

app.listen(3000, () => {
  console.log('Server listening on port 3000!');
});
