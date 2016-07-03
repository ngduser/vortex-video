var mongoose = require('mongoose');
mongoose.connect('mongodb://localhost/test');

const videoSchema = {
  title: String,
  url: String,
  thumbnail_url: String,
  desc: String,
};

var Video = mongoose.model('Video', videoSchema);

var video = new Video({
  title: "Ping Pong",
  url: "https://s3.amazonaws.com/umuc.cmsc495.vigilant-video/PingPong.mp4",
  thumbnail_url: "https://s3.amazonaws.com/umuc.cmsc495.vigilant-video/PingPong.jpg",
  desc: "Great song from Ping Pong the Animation",
});

video.save( (err) => {
  if (err) {
    console.log(err);
  } else {
    console.log("Video saved.");
  }
  mongoose.connection.close();
});
