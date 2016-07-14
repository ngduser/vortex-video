const videoSchema = {
  title: String,
  url: String,
  thumbail_url: String,
  desc: String,
};

exports.routes = function(app, mongoose) {

  var Video = mongoose.model('Video', videoSchema);

  app.get('/featured', (req, res) => {
    Video.find( (err, videos) => {
      if (err) return console.error(err);
      res.json(videos);
    });
  });

  app.get('/popular', (req, res) => {
    res.send('popular videos');
  });

  app.get('/api/video', (req, res) => {
    Video.findOne( { _id: req.query.id }, (err, video) => {
      if (err) return console.error(err);
      res.json(video);
    });
  });
}

