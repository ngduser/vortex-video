import React, { Component } from 'react';
import Video from '../common/Video.js';

class WatchPage extends Component {

  state = {
      video: null,
  };

  componentDidMount() {
    const video_id = this.props.location.query.v;
    this.serverRequest = $.get(`/api/video?id=${video_id}`, (data) => {
      this.setState({ video: data });
    });
  }

  componentWillUnmount() {
    this.serverRequest.abort();
  }

  render() {
    const { video } = this.state;
    let CurrentVideo = null;
    if ( video === null ) {
      CurrentVideo = () => <div></div>;
    } else {
      CurrentVideo = () => (
        <div style={{
          textAlign: "center"
        }}>
          <Video src={video.url}/>
          <h3>{video.title}</h3>
          <p>
            {video.desc}
          </p>
        </div>
      );
    }
    return (
        <CurrentVideo />
    );
  }
}

export default WatchPage;
