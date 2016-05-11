var osc = require('node-osc'),
    io = require('socket.io').listen(8081);

var oscServers = {};
var oscClient;

io.sockets.on('connection', function (socket) {
  socket.on("config", function (obj) {
    console.log('got config', obj);
    var serverKey = "" + obj.server.port + obj.server.host;
    var oscServer = oscServers[serverKey];
    if (typeof oscServer === "undefined") {
      oscServer = new osc.Server(obj.server.port, obj.server.host);
      oscServers[serverKey] = oscServer;
    }
    oscClient = new osc.Client(obj.client.host, obj.client.port, oscServer);

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