import React, { Component } from 'react';
import FeatureCarousel from './FeatureCarousel.js';
import $ from 'jquery';
import ImageLink from '../common/ImageLink.js';
import { Link } from 'react-router';

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
      image_cells = this.state.videos.map( (video) => {
        const link_uri = `/watch?v=${video._id}`;
        return (
          <td style={ cellStyle } key={video.url} >
            <div>
              <ImageLink to={link_uri} 
                         src={video.thumbnail_url}
                         alt={video.title}
                         style={ this.style }
               />
               <div style={{ textAlign: "left" }}>
                 <Link to={link_uri}>{ video.title }</Link>
                 <p>{video.desc}</p>
               </div>
            </div>
          </td>
        ) });
    }

    return (
      <div className="container">
        <h3>Popular</h3>
        <div className="col-lg-12">
          <table className="table table-bordered" style={{ tableLayout: "fixed" }}>
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
