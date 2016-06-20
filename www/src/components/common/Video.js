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

export default Video;
