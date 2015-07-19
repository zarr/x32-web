<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>X32 webremote</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  
<script src="http://127.0.0.1:8081/socket.io/socket.io.js"></script>

<script>
   socket = io.connect('http://127.0.0.1', { port: 8081, rememberTransport: false});
   console.log('oi');
   socket.on('connect', function() {
        // sends to socket.io server the host/port of oscServer
        // and oscClient
        socket.emit('config',
            {
                //vastaanotto proxylta
                server: {
                    port: 3333,
                    host: '127.0.0.1'
                },
                //lahetys eli mikserin ip
                client: {
                    port: 53000,
                    host: '127.0.0.1'
                }
            }
        );
    });

    socket.on('message', function(obj) {
        var status = document.getElementById("status");
        status.innerHTML = obj[0];
        console.log(obj);
    });
</script>

<?php

// taulukko komennoista
$kontrollit = array(
	array( "caster 1 on", "/ch/01/mix/on", "button" ),
	array( "caster 2 on", "/ch/02/mix/on", "button" ),
	array( "caster 3 on", "/ch/03/mix/on", "button" )
	);

foreach ($kontrollit as $kontrolli) {
	echo "<button type=\"button\" class=\"btn btn-lg btn-default\" onclick=\"socket.emit('message','".$kontrolli[1]."');\">".$kontrolli[0]."</button>";
	echo "<br>\n";
};

?>


<br>
<br>
<p>
Received from an OSC app/device at : <div id="status"></div>
</p>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body> 
</html>
