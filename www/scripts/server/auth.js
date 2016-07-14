var crypto = require('crypto');

exports.routes = function(app, mongoose) {

  const userSchema = {
    username: {
      type: String,
      unique: true,
    },
    password: String,
    salt: String,
  }

  const User = mongoose.model('User', userSchema);

  const crypt_conf = {
    hashBytes: 64,
    saltBytes: 32,
    iterations: 10000,
    algorithm: 'sha512',
  }

  function verifyPassword( given_pass, storedHashPass, storedSalt, callback ) {
    hashPass( given_pass, storedSalt, (hashedPass) => {
      if (hashedPass === storedHashPass) {
        callback({
          success: true,
        });

      } else {
        callback({
          success: false,
          message: "FAILED_MATCH",
        });

      }
    }); // End hashPass callback
  }

  function storeUser(username, password, salt, db, callback) {
    console.log(`${username}, ${password}`);

    var user = new User({
      username: username,
      password: password,
      salt: salt,
    });

    user.save( (err) => {
      if (err) {
        if (err.code === 11000) {
          callback({ success: false, message: "DUPLICATE_USERNAME" });
        } else {
          callback({ success: false, message: err.message });
        }
      } else {
        callback({ success: true });
      }
    });
  }

  var genSalt = function(callback) {
    crypto.randomBytes( crypt_conf.saltBytes, (err, salt) => {
      if (err) {
        return callback(err);
      } else {
        return callback(err, salt.toString('hex'));
      }
    })
  }

  var hashPass = function(clear_pass, salt, callback) {
      crypto.pbkdf2( 
        clear_pass,
        salt,
        crypt_conf.iterations,
        crypt_conf.hashBytes,
        crypt_conf.algorithm,
        (err, hashedPass) => {
          if (err) throw err;
          callback(hashedPass.toString('hex'))
        }
    )
  }

  app.post('/auth/reg', (req, res) => {

    var reg = {
      name: req.body.username,
      pass1: req.body.pass1,
      pass2: req.body.pass2
    };

    if (reg.pass1 !== reg.pass2) {
      res.json({
        success: false,
        message: "PASSWORD_MISMATCH"
      });

    } else {
      genSalt( (err, salt) => {
        if (err) throw err;

        hashPass( reg.pass1, salt, (hashedPass) => {
          storeUser(reg.name, hashedPass, salt, mongoose, (res_obj) => {
            res.json(res_obj);
          }); // End storeUser callback
        } ); // End hashPass callback
      } );
    }
  }); // End app.post callback

  app.post('/auth/login', (req, res) => {
    const login = {
      name: req.body.username,
      pass: req.body.password,
    };

    User.findOne( { username: login.name }, (err, foundUser) => {
      // If there is a db error
      if (err) {
        console.log( err.code, err.message );

        res.json({
          success: false,
          message: "DB_ERROR",
        });

      // If a matching user wasn't found
      }  else if (foundUser === null) {
          res.json({
            success: false,
            session_id: "NO_SUCH_USER",
          });

      // Found a user! Verify password
      } else {
        verifyPassword( login.pass, foundUser.password, foundUser.salt, (verifyObj) => {

          // If password checks out
          if (verifyObj.success) {
            //console.log('Cookies: ', req.session.cookie);
            //console.log('Id: ', req.session.id);

            // Update the session and save it
            req.session.username = foundUser.username;
            req.session.save( (err) => {
              if (err) console.log(err);
            });

            // Send login success
            res.json({
              success: true,
            });

          } else {
            res.json({
              success: false,
              message: verifyObj.message,
            });
          }
        }); // End verifyPassword callback
      }

    }); // End User.findOne callback

  }); // End app.post auth/login callback

  app.post('/auth/checkSession', (req, res) => {
    if (req.session.username !== undefined) {
      res.json({
        success: true,
        username: req.session.username,
      });
    } else {
      res.json({
        success: false,
      });
    }
  }); // End app.post auth/checkSession callback

  app.post('/auth/logout', (req, res) => {
    req.session.destroy( (err) => {
      if (err) {
        console.log(err);
        res.json({
          success: false
        });
      } else {
        res.json({
          success: true
        });
      }
    });
  }); // End app.post auth/logout callback
}

