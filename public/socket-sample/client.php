
<h1>Data Socket Test</h1>
<div class="status"></div>
<div id="datadiv"></div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="jquery.simple.websocket.min.js"></script>

<script type="text/javascript">
    var conn = new WebSocket('ws://bino.com:9090/sample/socket.php');
    conn.onopen = function(e) {
        console.log(e);
    };

    conn.onmessage = function(e) {
        console.log(e.data);
    };

</script>

</body>
</html>