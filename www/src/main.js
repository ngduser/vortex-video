import React from 'react'
import { render } from 'react-dom'
import { Router, Route, IndexRoute,Link, browserHistory } from 'react-router'

// Components
import Nav from './components/nav/Nav.js';
import FrontPage from './components/frontPage/FrontPage.js'

const links = [
  { to: "about", text: "About" },
];

const App = (props) => (
  <div>
    <Nav links={links} />
    { props.children }
  </div>
);

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
      <Route path="*" component={NoMatch}/>
    </Route>
  </Router>
  ), document.getElementById('app')
);
