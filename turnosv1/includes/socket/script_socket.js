//Variable global un solo socket
var socket;

var iniciarSocket = function () {
    setSocket();
};
this.setSocket = function () {
    if (this.socket == null) {
        var host = "ws://127.0.0.1:9000/echobot";
        try {
            this.socket = new ReconnectingWebSocket(host, null, {debug: true, reconnectInterval: 3000});
        }
        catch (ex) {
            console.log(ex.message);
        }
    }

};
this.getSocket = function () {
    return this.socket;
};
this.send = function (data) {
    var msg;
    msg = data;
    try {
        this.socket.send(msg);
    } catch (ex) {
        console.log(ex.message);
    }
};
