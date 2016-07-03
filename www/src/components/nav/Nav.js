import React, { Component } from 'react';
import { Link } from 'react-router';
import $ from 'jquery';

class Nav extends Component {
  //state = {
  //  loggedIn: false,
  //  username: "",
  //}

  //componentDidMount() {
  //  this.serverRequest = $.post('/auth/checkSession', (data) => {
  //    console.log(data);
  //    this.setState({
  //      loggedIn: data.success,
  //      username: data.username,
  //    });
  //  });
  //}

  //componentWillUnmount() {
  //  this.serverRequest.abort();
  //}

  render() {
    var links = [];
    if (this.props.links) {
      links = this.props.links.map( (link) => (
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

            { this.props.children }

          </div>
        </div>
      </nav>
    );
  }
}

export default Nav;
