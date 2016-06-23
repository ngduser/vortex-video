import React, { Component } from 'react';
import { Link } from 'react-router';

const LoginForm = () => (
  <div className="container col-md-8">
    <section>
      <h1 className="text-center">Welcome to Vigilant Video</h1>
      <h2 className="text-center">Login to your account</h2>

      <div className="panel panel-default ">
	<div className="panel-body">

	  <form className="form form-horizontal" style={{padding: "5px" }}action="/Login" method="POST">

	    <div className="form-group">
	      <label for="username">Username:</label>
	      <input className="form-control" type="text" name="username" autoComplete="off"/>
	    </div>

	    <div className="form-group">
	      <label for="password">Password:</label>
	      <input className="form-control" type="password" name="password" />
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

export default LoginForm;
