import React, { Component } from 'react';
import FeatureCarousel from './FeatureCarousel.js';
import Video from './Video.js';
import $ from 'jquery';

const sliderStyle = {
  height: "250px",
}

const imgStyle = {
  maxHeight: "100px",
};

const cellStyle = {
  textAlign: "center",
};

class Popular extends Component {
  state = {
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

  render() {
    var image_cells = null;
    if (this.state.videos !== null) {
      image_cells = this.state.videos.map( (video) => (
        <td style={ cellStyle } key={video.url} >
          <img style={ imgStyle }
               src={video.url.replace(/webm|mp4/, "jpg") }
               alt={video.title} />
        </td>
      ) );
    }

    return (
      <div className="container">
        <h3>Popular</h3>
        <div className="col-lg-12">
          <table className="table table-bordered">
            <tbody>
              <tr>
                { image_cells }
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    );
  }
}

const FrontPage = () => (
  <div>
    <FeatureCarousel />
    <Popular />
  </div>
);

export default FrontPage;
