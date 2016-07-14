var express = require('express');
//var cookieParser = require('cookie-parser');
var app = express();

//app.use(cookieParser('test'));

var bodyParser = require('body-parser');
app.use( bodyParser.json() );
app.use( bodyParser.urlencoded({
  extended: true
}) );

var mongoose = require('mongoose');
mongoose.connect('mongodb://localhost/test');

// Sessions
const session = require('express-session');
const MongoStore = require('connect-mongo')(session);

app.use(session({
  secret: 'test',
  store: new MongoStore({
    mongooseConnection: mongoose.connection
  })
}));

// Import the Video routes
require('./videos').routes(app, mongoose);

// Import the authentication/registration routes
require('./auth').routes(app, mongoose);

// Import the profile routes
require('./profile').routes(app, mongoose);

// Import live chat
require('./chat').io(app);

app.listen(3000, () => {
  console.log('Server listening on port 3000!');
});
