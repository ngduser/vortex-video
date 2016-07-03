
exports.routes = function(app, mongoose) {
  const commentSchema = mongoose.Schema({
    username: String,
    message: String,
  });

  const profileSchema = mongoose.Schema({
    username: {
        type: String,
        unique: true,
    },
    intro_line: String,
    comments: [commentSchema]
  });

  var Profile = mongoose.model('Profile', profileSchema);

  app.get('/api/profile', (req, res) => {
    const query_username = req.query.user;

    Profile.findOne( { username: query_username }, (err, foundProfile) => {
      if (err) {
        console.log(err);
        res.json({ success: false }); 
      }

      if (foundProfile === null) {
        res.json({
          success: false,
          message: "NO_PROFILE_FOUND"
        }); 

      } else {
        // Add success
        let result = foundProfile;
        result.success = true;
        res.json(result);
      }
      
    }); // End profile.findOne callback
  }); // End get profile callback

  app.post('/api/profile/comment', (req, res) => {
    const targetUser = req.body.targetUser;
    const username = req.body.username;
    const message  = req.body.message;

    Profile.findOne({ username: targetUser }, (err, foundProfile) => {
      if (err) {
        console.log( err.code, err.message );

        res.json({
          success: false,
          message: "DB_ERROR",
        });

      // If a matching profie wasn't found
      }  else if (foundProfile === null) {
          console.log("Profile not found");
          res.json({
            success: false,
            message: "NO_SUCH_PROFILE",
          });

      // Found a profile! Add the comment
      } else {
        console.log(foundProfile);
        foundProfile.comments.push({
          username: username,
          message: message,
        });

        foundProfile.save( (err) => err && console.log(err) ) ;

        res.json({
          success: true,
          message: "comment saved"
        });
      }

    });
  });

  app.post('/api/profile/create', (req, res) => {

      var profile = new Profile({
        username: req.body.username,
        intro_line: req.body.intro_line,
      });

      profile.save( (err) => {
        if (err) {
          if (err.code === 11000) {
            res.json({ success: false, message: "DUPLICATE_PROFILE" });
          } else {
            res.json({ success: false, message: err.message });
          }
        } else {
          res.json({ success: true });
        }
      }); // end profile save callback
    }); // end profile/create callback

}
