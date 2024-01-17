<?php
    
   if ((empty($_POST["startTimestamp"])) || (empty($_POST["endTimestamp"]))){
        die("Timestamp required");
   }

   $mysqli = require __DIR__ ."/database.php";

   $selectedColumn =$mysqli -> real_escape_string($_POST["selectedColumn"]);

   
   $sql = sprintf("SELECT %s FROM sampleinputdata 
                    WHERE timestamp = '%s';",
                    $selectedColumn,     
                    $mysqli -> real_escape_string($_POST["startTimestamp"]));
    
   echo $sql;
   $result = $mysqli -> query($sql);

   while($row = $result->fetch_assoc()) 
        { 
            $column_data[] = $row;
            echo "$selectedColumn: " . $row["$selectedColumn"] . "<br>";
        } 
    
    /*foreach ($dataFuelMainfold as $dataFuelMainfold) {
        echo $dataFuelMainfold['data_Fuel_manifold_Pressure'] . "<br>";
    }*/

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://d3js.org/d3.v4.js"></script>
</head>
<body>
    <script>
        // PHP echoes the data in JSON format
        var rawData = <?php echo json_encode($column_data); ?>;
        var selectedColumn = "<?php echo $selectedColumn; ?>";

        // Extracting the values from the selected column
        var data_column = rawData.map(function(d) {
            return d[selectedColumn];
        });

        var container = d3.select("body")
            .append("svg")
            .attr("height", 500)
            .attr("width", 700)
            .append("g")
            .attr("transform", "translate(100,100)");

        var xScale = d3.scaleLinear()
                        .domain([0, data_column.length - 1])
                        .range([0, 500]);

        var yScale = d3.scaleLinear()
                        .domain([d3.min(data_column), d3.max(data_column)])
                        .range([100, 0]);

        var scale = d3.scaleLinear().domain([0, data_column.length]).range([0, 500]);
        var axis = d3.axisBottom(scale);

        var line = container.selectAll("line")
            .data(data_column)
            .enter()
            .append("line")
            .attr("x1", function (d, i) { return xScale(i); })
            .attr("y1", function (d) { return yScale(d); })
            .attr("x2", function (d, i) { return xScale(i + 1); }) 
            .attr("y2", function (d) { return yScale(d); })
            .attr("stroke", "green");

        container.append("g")
                    .attr("transform","translate(0,150)")
                    .call(axis);
                
    </script>
</body>
</html>
