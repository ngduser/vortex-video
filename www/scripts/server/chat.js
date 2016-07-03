
exports.io = function(app) {
  var http = require('http').Server(app);
  var io = require('socket.io')(http);

  io.on('connection', (socket) => {
    console.log(' a user connected');

    socket.on('disconnect', () => {
      console.log(' user disconnected');
    });

    socket.on('client:sendMessage', (message) => {
      io.emit('server:sendMessage', message);
      console.log('message: ' + message );
    })
  });

  http.listen(3001, function() {
    console.log("Chat listening on 3001");
  });
}
