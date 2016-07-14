import React, { Component } from 'react';
import { Link } from 'react-router';

const defaultStyle = {
  imageLinkContainer: {
    textAlign: "center",
  },

  img: {
    maxHeight: "300px"
  },
};

const ImageLink = (props) => {
  let style = null;
  if (props.style !== undefined) {
    style = props.style;
  } else {
    style = defaultStyle
  }

  return (
    <div style={style.imageLinkContainer}>
      <Link to={props.to}>
        <img src={props.src}
             alt={ props.alt == undefined ? "" : props.alt }
             style={ style.img }
        />
      </Link>
      { props.children }
    </div>
  );
};

export default ImageLink;
