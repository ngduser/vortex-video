var mongoose = require('mongoose');
mongoose.connect('mongodb://localhost/test');

const videoSchema = {
  title: String,
  url: String,
  desc: String,
};

var Video = mongoose.model('Video', videoSchema);

var video = new Video({
  title: "Avenue Q",
  url: "https://s3.amazonaws.com/umuc.cmsc495.vigilant-video/AvenueQ.webm",
  desc: "Song which describes the main usage of the Internet.",
});

video.save( (err) => {
  if (err) {
    console.log(err);
  } else {
    console.log("Video saved.");
  }
});
