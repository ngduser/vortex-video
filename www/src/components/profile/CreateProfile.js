import React, { Component } from 'react';
import $ from 'jquery';

class CreateProfile extends Component {
  state = {
    validUser: false,
    username: "",
    intro_line: "",
  };

  componentDidMount() {
    this.serverRequest = $.post('/auth/checkSession', (data) => {
      if (data.success) {
        this.setState({
          validUser: data.success,
          username: data.username,
        });
      } else {
        this.context.router.push(`/login`);
      }
    });
  }

  handleSubmit = (e) => {
    e.preventDefault();

    this.createProfileRequest = $.ajax({
      url: "/api/profile/create",
      type: "POST",
      dataType: 'json',
      async: true,
      data: this.state,
      success: (data) => {
        if (data.success === true) {
          this.context.router.push(`/profile/${this.state.username}`);
        }
        console.log(data);
      },
    });
  };

  setIntroLine = (e) => this.setState( { intro_line: e.target.value } );

  render() {
    if (this.state.validUser) {
      return this.createProfileForm();
    } else {
      return this.loadingProfile();
    }
  }

  loadingProfile() {
    return (
      <div>
        <p>Profile loading...</p>
      </div>
    );
  }

  createProfileForm() {
    return (
      <div className="container col-md-8">
        <section>
          <h1 className="text-center">Create your profile</h1>

          <div className="panel panel-default ">
            <div className="panel-body">

              <form className="form form-horizontal" style={{padding: "5px" }} 
                    onSubmit={ this.handleSubmit }>

                <div className="form-group">
                  <label htmlFor="intro_line">Intro Line:</label>
                  <input className="form-control" type="text" autoComplete="off"
                         value={this.state.intro_line} onChange={this.setIntroLine}/>
                </div>

                <div className="form-group">
                  <button type="submit" className="btn btn-primary pull-right" name="loginBtn">Create</button>
                </div>

              </form>

            </div>
          </div>
        </section>
      </div>
    );
  }
}

CreateProfile.contextTypes = {
  router: React.PropTypes.object.isRequired
};

export default CreateProfile;
