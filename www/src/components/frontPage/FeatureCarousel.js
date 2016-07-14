import React, { Component } from 'react';
import $ from 'jquery';
import Video from '../common/Video.js';
import ImageLink from '../common/ImageLink.js';

class FeatureCarousel extends Component {
  state = {
    index: 0,
    videos: null
  };

  componentDidMount() {
    this.serverRequest = $.get('/featured', (data) => {
      this.setState({ videos: data });
    });
  }

  componentWillUnmount() {
    this.serverRequest.abort();
  }

  incrementVideo = () => {
    if (this.state.index < this.state.videos.length - 1) {
      this.setState({ index: this.state.index + 1 });
    }
  };

  decrementVideo = () => {
    if (this.state.index > 0) {
      this.setState({ index: this.state.index - 1 });
    }
  };

  render() {
    const { videos, index } = this.state;
    const active_video = videos === null ? "" : videos[index];
    const CurrentVideo = (props) => (
      <ImageLink to={`/watch?v=${active_video._id}`} 
                 src={active_video.thumbnail_url}
                 alt={active_video.title}>
        { props.children }
      </ImageLink>
    );
    return (
      <div className="container">
        <div className="carousel">
          <CurrentVideo>
            <div style={{
            }}>
              <h3>{active_video.title}</h3>
              <p>
                {active_video.desc}
              </p>
            </div>
          </CurrentVideo>
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

export default FeatureCarousel;
