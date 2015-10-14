var osc = require('node-osc'),
    io = require('socket.io').listen(8081);

var oscServer, oscClient;

io.sockets.on('connection', function (socket) {
  socket.on("config", function (obj) {
    console.log('got config', obj);
    oscServer = new osc.Server(obj.server.port, obj.server.host);
    oscClient = new osc.Client(obj.client.host, obj.client.port);

    oscClient.send('/status', socket.sessionId + ' connected');

    setInterval(function () {
      oscClient.send('/xremote');
    }, 7000);

    oscServer.on('message', function(msg, rinfo) {
      console.log(msg, rinfo);
      socket.emit("message", msg);
    });
  });
  socket.on("message", function (obj) {
    oscClient.send(obj);
    console.log('from ui', obj);
  });
});