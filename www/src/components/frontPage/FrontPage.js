import React, { Component } from 'react';
import FeatureCarousel from './FeatureCarousel.js';
import $ from 'jquery';
import ImageLink from '../common/ImageLink.js';

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

  style = {
    imageLinkContainer: {
      textAlign: "center",
    },
    img: {
      maxHeight: "100px",
    }
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
          <ImageLink to={`/watch?v=${video._id}`} 
                     src={video.thumbnail_url}
                     alt={video.title}
                     style={ this.style }
           />
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
