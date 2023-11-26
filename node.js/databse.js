var mysql      = require('mysql2');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'Nottheend321',
  database : 'try'
});
 
connection.connect();
 
connection.query('SELECT timestamp from sampleinputdata', function (error, results, fields) {
  if (error) throw error;
  console.log('The solution is: ', results);
});
 
connection.end();