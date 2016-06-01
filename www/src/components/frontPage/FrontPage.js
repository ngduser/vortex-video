import React, { Component } from 'react';

class Video extends Component {
  render() {
    return (
      <div>
        <video className="center-block" controls>
          <source src={this.props.src}></source>
          Your browser does not support HTML5 Video.
        </video>
      </div>
    );
  }
}

const bucketUrl = "https://s3.amazonaws.com/umuc.cmsc495.vigilant-video";
const videos = ["TheOneTheyFear.mp4", "PingPong.mp4", "AvenueQ.webm"];

class FrontPage extends Component {
  state = {
    index: 0,
  };

  incrementVideo = () => {
    if (this.state.index < videos.length - 1) {
      this.setState({ index: this.state.index + 1 });
    }
  };

  decrementVideo = () => {
    if (this.state.index > 0) {
      this.setState({ index: this.state.index - 1 });
    }
  };

  render() {
    const active_video_url = bucketUrl + "/" + videos[this.state.index];
    const CurrentVideo = () => <Video src={active_video_url} />;
    return (
      <div className="container">
        <div className="carousel">
          <CurrentVideo />
          <button className="left carousel-control"
                  onClick={this.decrementVideo}>
            <span className="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          </button>
          <button className="right carousel-control"
                  onClick={this.incrementVideo}>
            <span className="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    );
  }
}

export default FrontPage;
