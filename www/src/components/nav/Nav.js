import React, { Component } from 'react';
import { Link } from 'react-router';

const Nav = (props) => {
  
  var links = [];
  if (props.links) {
    links = props.links.map( (link) => (
      <li key={link.to}><Link to={link.to}>{link.text}</Link></li>
    ));
  }

  return (
    <nav className="navbar navbar-inverse navbar-static-top">
      <div className="container">
	<div className="navbar-header">
	  <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	    <span className="sr-only">Toggle navigation</span>
	    <span className="icon-bar"></span>
	    <span className="icon-bar"></span>
	    <span className="icon-bar"></span>
	  </button>
	  <Link className="navbar-brand" to="/">Vigilant Video</Link>
	</div>
	<div id="navbar" className="collapse navbar-collapse">
	  <ul className="nav navbar-nav">
            { links }
	  </ul>
	</div>
      </div>
    </nav>
  );
}

export default Nav;
