import React, { Component } from 'react';
import CommentBox from './CommentBox';

class ProfilePage extends Component {
  state = {
    currentUser: "",
    foundUser: false,
    intro_line: "",
    comments: [],
  }

  componentDidMount() {
    const user = this.props.location.query.user; 
    this.serverRequest = $.get(`/api/profile?user=${user}`, (data) => {
      if (data.username !== undefined) {
        console.log(data);
        this.setState({
          foundUser: true,
          intro_line: data.intro_line,
          comments: data.comments,
        });
      }
    });

    this.userRequest = $.post('/auth/checkSession', (data) => {
      this.setState({
        currentUser: data.username,
      });
    });
  }

  componentWillUnmount() {
    this.serverRequest.abort();
    this.userRequest.abort();
  }

  render() {
    const user = this.props.location.query.user; 

    if (this.state.foundUser) {
      return (
        <div className="container">
          <h1>{user}'s Profile Page</h1>
          <h2>{user} says, "{this.state.intro_line}"</h2>
          <h3>Comments</h3>
          <CommentBox username={user}
                      currentUser={this.state.currentUser}
                      comments={this.state.comments}/>
        </div>
      );
    } else {
      return (
        <div className="container">
          <h1>No user found with that name</h1>
          <p>
            Sorry bro.
          </p>
        </div>
      );
    }
  }
}

export default ProfilePage;
