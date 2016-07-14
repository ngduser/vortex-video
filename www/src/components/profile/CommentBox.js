import React, { Component } from 'react';

class CommentBox extends Component {

  state = {
    comments: this.props.comments
  };

  addComment = (message) => {

    var currentUser;
    if (this.props.currentUser === undefined) {
      currentUser = "Anonymous";
    } else {
      currentUser = this.props.currentUser;
    }

    const message_obj = {
      targetUser: this.props.username,
      username: currentUser,
      message: message,
    };

    // Add the comment to local state
    this.state.comments.push(message_obj);

    this.setState({
      comments: this.state.comments,
    });

    // Persist the new comment to the DB
    this.serverRequest = $.ajax({
      url: "/api/profile/comment",
      type: "POST",
      dataType: 'json',
      async: true,
      data: message_obj,
      success: (data) => {
        console.log(data.message);
      },
    });
  };

  render() {
    // Create the comments
    var comments = "";
    if (this.state.comments.length !== 0 ) {
      let reversed_comments = this.state.comments.slice();
      reversed_comments.reverse();
      comments = reversed_comments.map( (comment, index) => {
        return (
          <Comment key={index} comment={comment} />
        );
      });
    }

    return (
      <div>
        <CommentForm addComment={this.addComment.bind(this)} />
        { comments }
      </div>
    );
  }
}

const Comment = (props) => (
  <div className="col-md-12">
    <div className="panel panel-default">
      <div className="panel-heading">{props.comment.username}</div>
      <div className="panel-body">
        {props.comment.message}
      </div>
    </div>
  </div>
);

class CommentForm extends Component {
  state = {
    message: ""
  };

  handleSubmit = (e) => {
    e.preventDefault();
    this.props.addComment(this.state.message);
    this.setState({
      message: "",
    });
  }

  setMessage = (e) => this.setState( { message: e.target.value } );

  render() {
    return (
      <div className="col-md-12">

        <div className="panel panel-default">
          <div className="panel-body">
            <form onSubmit={this.handleSubmit}>
              <div className="form-group">
                <label>Comment:</label>
                <input className="form-control" type="text" autoFocus
                       value={this.state.message} onChange={this.setMessage} />
              </div>
              <div className="form-group">
                <button type="submit" className="btn btn-primary pull-right">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    );
  }
}

export default CommentBox;
