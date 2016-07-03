import React, { Component } from 'react';
import { render } from 'react-dom';
import { Router, Route, IndexRoute, Link, browserHistory } from 'react-router';

// Components
import Nav from './components/nav/Nav.js';
import FrontPage from './components/frontPage/FrontPage.js';
import LoginForm from './components/login/LoginForm.js';
import RegisterForm from './components/register/RegisterForm.js';
import ProfilePage from './components/profile/ProfilePage.js';
import CreateProfile from './components/profile/CreateProfile.js';

import LogoutForm from './components/logout/LogoutForm.js';
import WatchPage from './components/watchPage/WatchPage.js';

const links = [
  { to: "about", text: "About" },
  //{ to: "login", text: "Login" },
  //{ to: "register", text: "Register" },
];

class App extends Component {
  state = {
    loggedIn: false,
    username: "",
  };

  componentDidMount() {
    this.serverRequest = $.post('/auth/checkSession', (data) => {
      console.log(data);
      this.setState({
        loggedIn: data.success,
        username: data.username,
      });
    });
  }

  componentWillUnmount() {
    this.serverRequest.abort();
  }

  sendLogout = () => {
    this.serverRequest = $.post('/auth/logout', (data) => {
      if (data.success) {
        this.setState({
          loggedIn: !data.success,
          username: "",
        });
      }
    });
  }
  
  render() {
    var LogButtons;
    if (this.state.loggedIn === true) {

      const profileLink = `/profile?user=${this.state.username}`;

      LogButtons = () => (
        <ul className="nav navbar-nav pull-right">
          <li>
            <a href="#" onClick={this.sendLogout}>Logout</a>
          </li>
          <li>
            <Link to={profileLink}>{this.state.username}</Link>
          </li>
          <li>
            <Link to="/createProfile">Create Profile</Link>
          </li>
        </ul>
      );

    } else {
      LogButtons = () => (
        <ul className="nav navbar-nav pull-right">
          <li>
            <Link to="/login">Login</Link>
          </li>
          <li>
            <Link to="/register">Register</Link>
          </li>
        </ul>
      );
    }

    return (
      <div>
        <Nav links={links} loggedIn={this.state.loggedIn}>
          { LogButtons() }
        </Nav>
        { this.props.children }
      </div>
    );
  }
}

const About = () => (
  <div className="container">
    <h1>About</h1>
    <p>
      Welcome to Vigilant Video! This is a class project. Enjoy!
    </p>
  </div>
);

const NoMatch = () => (
  <div className="container">
    <h1>404</h1>
  </div>
);

render((
  <Router history={browserHistory}>
    <Route path="/" component={App}>
      <IndexRoute component={FrontPage} />
      <Route path="about" component={About}/>
      <Route path="login" component={LoginForm}/>
      <Route path="register" component={RegisterForm}/>
      <Route path="logout" component={LogoutForm}/>
      <Route path="profile" component={ProfilePage}/>
      <Route path="createProfile" component={CreateProfile}/>
      <Route path="watch" component={WatchPage}/>
      <Route path="*" component={NoMatch}/>
    </Route>
  </Router>
  ), document.getElementById('app')
);
