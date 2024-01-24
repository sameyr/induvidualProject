<?php
    
    if((empty($_POST["startTimestamp"])) || (empty($_POST["endTimestamp"]))){
        die("Error, please enter proper value in timestamp box.");
   } 
    

   if ((strtotime($_POST["endTimestamp"])) <  (strtotime($_POST["startTimestamp"]))){
        die("Error, please try again.<br> End Time is greater than Start Time.");
   }

   $mysqli = require __DIR__ ."/database.php";

   
   $selectedColumn =$mysqli -> real_escape_string($_POST["selectedColumn"]);
   
   $selectedColumnString = isset($_POST["selectedColumn"]) ? $_POST["selectedColumn"] : '';
   $selectedColumnArray = explode(",", $selectedColumnString);
   //$escapedColumns = array_map([$mysqli, 'real_escape_string'], $selectedColumnArray);

   $sql = sprintf("SELECT %s FROM sampleinputdata
                    WHERE STR_TO_DATE(timestamp, '%%m/%%d/%%Y %%H:%%i') 
                    BETWEEN STR_TO_DATE('%s', '%%m/%%d/%%Y %%H:%%i')
                    AND STR_TO_DATE('%s', '%%m/%%d/%%Y %%H:%%i');",
                    $selectedColumn,     
                    $mysqli -> real_escape_string($_POST["startTimestamp"]),
                    $mysqli -> real_escape_string($_POST["endTimestamp"]));
   
   
    echo $sql . "<br>";                    
    $result = $mysqli -> query($sql);


    // Initialize an array to hold the data for each selected column
    $columnData = [];


    while ($row = $result->fetch_assoc()) {  //fetching rows for multiple column
        foreach ($selectedColumnArray as $column) {
            $columnData[$column][] = [
                'value' => $row[$column],
            ];
        }
    }

    echo(array_value($columnData));

    // prints the data for each selected column
    /*foreach ($columnData as $column => $data) {
        echo "$column:<br>";
        foreach ($data as $item) {
            echo  "Value: " . $item['value'] . "<br>";
        }
        echo "<br>";
    }*/
   

   /*while($row = $result->fetch_assoc()) // fetching rows for only one column
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
         // Encode $columnData as an indexed array before outputting
        var rawData =<?php echo json_encode(array_values($columnData)); ?>;
        var selectedColumn = "<?php echo $selectedColumnArray[0]; ?>";

        // Extracting the values from the selected columns
        var data_column = rawData.map(function(d) {
            return d[selectedColumn];
        });

        console.log(data_column);
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
