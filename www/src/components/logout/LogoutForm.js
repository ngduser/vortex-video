import React, { Component } from 'react';
import $ from 'jquery';

class LogoutForm extends Component {
  state = {
    loggedOut: false,
  };

  componentDidMount() {
    this.serverRequest = $.post('/auth/logout', (data) => {
      this.setState({ loggedOut: data.success });
    });
  }

  componentWillUnmount() {
    this.serverRequest.abort();
  }

  render() {
    var successMessage;
    if (this.state.loggedOut ===  true) {
      successMessage = "You have been logged out."
    } else {
      successMessage = "Something went wrong. Looks like you're stuck here forever.";
    }

    return (
      <div>
        <h1>Logout</h1>
        <p>
          {successMessage}
        </p>
      </div>
    );
  }

}

export default LogoutForm;
