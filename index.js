var express = require('express');
var server = express();
var options = {
index: 'default.php'
};
server.use('/', express.static('/home/site/wwwroot', options));
server.listen(process.env.PORT);
