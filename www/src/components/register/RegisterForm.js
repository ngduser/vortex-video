import React, { Component } from 'react';
import { Link } from 'react-router';

const RegisterForm = () => (
<div className="container col-md-8">

  <section>
    <h1 className="text-center">Welcome to Vigilant Video</h1>
    <h2 className="text-center">Register an account</h2>

    <div className="panel panel-default ">
      <div className="panel-body">

	<form className="form form-horizontal somePadding" 
              style={{ padding: "5px" }}
              action="/auth/reg" method="POST">

	  <div className="form-group">
	    <label htmlFor="username">Desired Username:</label>
	    <input className="form-control" type="text" name="username" />
	  </div>

	  <div className="form-group">
	    <label htmlFor="password">Password:</label>
	    <input className="form-control" type="password" name="pass1" />
	  </div>

	  <div className="form-group">
	    <label htmlFor="password">Re-enter Password:</label>
	    <input className="form-control" type="password" name="pass2" />
	  </div>

	  <div className="form-group">
	    <input type="submit" className="btn btn-primary pull-right" name="register" value="Register" />
	  </div>
	</form>

	<p>
	  <small>Already have an account? Login <Link to="/login">here</Link>.</small>
	</p>
      </div>
    </div>
  </section>
</div>
);

export default RegisterForm;
