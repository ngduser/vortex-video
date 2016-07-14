import React, { Component } from 'react';
import { Link } from 'react-router';
import $ from 'jquery';

class LoginForm extends Component {
  //constructor(props, context) {
  //  super(props);

  //  this.state = {
  //    username: "",
  //    password: "",
  //  };
  //}
  state = {
     username: "",
     password: "",
  };

  componentWillUnmount() {
    if (this.serverRequest !== undefined) {
      this.serverRequest.abort();
    }
  };

  handleSubmit = (e) => {
    e.preventDefault();

    this.serverRequest = $.ajax({
      url: "/auth/login",
      type: "POST",
      dataType: 'json',
      async: true,
      data: this.state,
      success: (data) => {
        if (data.success === true) {
          this.context.router.push('/');
        }
        console.log(data);
      },
    });
  };

  setUsername = (e) => this.setState( { username: e.target.value } );
  setPassword = (e) => this.setState( { password: e.target.value } );

  render() {
    return (
      <div className="container col-md-8">
        <section>
          <h1 className="text-center">Welcome to Vigilant Video</h1>
          <h2 className="text-center">Login to your account</h2>

          <div className="panel panel-default ">
            <div className="panel-body">

              <form className="form form-horizontal" style={{padding: "5px" }} 
                     action="/auth/login" onSubmit={ this.handleSubmit }>

                <div className="form-group">
                  <label htmlFor="username">Username:</label>
                  <input className="form-control" type="text" autoComplete="off"
                         value={this.state.username} onChange={this.setUsername}/>
                </div>

                <div className="form-group">
                  <label htmlFor="password">Password:</label>
                  <input className="form-control" type="password" name="password" 
                         value={this.state.password} onChange={this.setPassword}/>
                </div>

                <div className="form-group">
                  <button type="submit" className="btn btn-primary pull-right" name="loginBtn">Login</button>
                </div>

              </form>

              <p>
                <small>Don't have an account? Register <Link to="/register">here</Link>.</small>
              </p>

            </div>
          </div>
        </section>
      </div>
    );
  }
}

LoginForm.contextTypes = {
  router: React.PropTypes.object.isRequired
};

export default LoginForm;
