import React, { Component } from 'react';
import Video from '../common/Video.js';
import io from 'socket.io-client';

var socket = io('/');


class WatchPage extends Component {


  state = {
      video: null,
  };

  componentDidMount() {
    const video_id = this.props.location.query.v;
    this.serverRequest = $.get(`/api/video?id=${video_id}`, (data) => {
      this.setState({ video: data });
    });
  }

  componentWillUnmount() {
    this.serverRequest.abort();
  }

  render() {
    const { video } = this.state;
    let CurrentVideo = null;
    if ( video === null ) {
      CurrentVideo = () => <div></div>;
    } else {
      CurrentVideo = () => (
        <div style={{
          textAlign: "center"
        }}>
          <Video src={video.url}/>
          <h3>{video.title}</h3>
          <p>
            {video.desc}
          </p>
        </div>
      );
    }
    return (
      <div>
        <CurrentVideo />
        <Chat />
      </div>
    );
  }
}

class Chat extends Component {

  constructor() {
    super();

    socket.on('server:sendMessage', (newMessage) => {
      this.state.chatMessages.push(newMessage);
      this.setState({ chatMessage: this.state.chatMessages });
    });

    this.state = {
      message: "",
      chatMessages: [],
    };

  }

  setMessage = (e) => this.setState({ message: e.target.value });

  handleSubmit = (e) => {
    e.preventDefault();

    socket.emit('client:sendMessage', this.state.message);
    this.setState({message: ""});
  };

  render() {
    const ChatMessages = () => {
      let liMessages = this.state.chatMessages.map( (message, index) => {
        return (
          <li key={index}>{message}</li>
      )});
      return (
        <ul style={{ "listStyle": "none"}}>
          { liMessages }
        </ul>
      )
    };
    return (
      <div className="container">
        <div className="col-md-12">
        
          <div className="panel panel-default">
            <div className="panel-heading">
              Chat about the video!
            </div>
            <div className="panel-body">
              
              <ChatMessages />
              
              <form onSubmit={this.handleSubmit}>
              
                <div className="form-group">
                  <input className="form-control" type="text" autoFocus
                         value={this.state.message} onChange={this.setMessage} />
                  <div className="form-group">
                    <button type="submit" className="btn btn-primary pull-right">Post</button>
                  </div>
                </div>
              
              </form>
            </div>
          </div>
        
        </div>
      </div>
    );
  }
}

export default WatchPage;
