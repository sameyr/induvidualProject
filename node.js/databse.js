var mysql      = require('mysql2');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'Nottheend321',
  database : 'try'
});
 
connection.connect();
 
connection.query('SELECT * from sampleinputdata where timestamp = "04/12/2013 04:00"', function (error, results, fields) {
  if (error) throw error;
  console.log('The solution is: ', results);
});
 
connection.end();