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

    while ($row = $result->fetch_assoc()) {
        foreach ($selectedColumnArray as $column) {
            $columnData[$column][] = $row[$column];
        }
    }

    //print_r ($columnData); //prints everything in multi-dimensional array

    
    // prints the data for each selected column
    foreach ($columnData as $column => $data) {
        echo "<br>$column:<br>";
        foreach ($data as $value) {
            echo  "Value: " . $value . "<br>";
        }
        echo "<br>";
    }


?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://d3js.org/d3.v4.js"></script>
</head>
<body>
    <script>
         // Encode $columnData as an indexed array before outputting
        var columnData =<?php echo json_encode($columnData); ?>;
       
        //Extracting all the column name and storing it in an array
        var columns = Object.keys(columnData);

        // Extracting the values from the selected columns
        var data = columns.map(function(columns) {
            return columnData[columns];
        });
        
        var container = d3.select("body")
            .append("svg")
            .attr("height", 500)
            .attr("width", 700)
            .append("g")
            .attr("transform", "translate(100,100)");

        var xScale = d3.scaleLinear()
                        .domain([0, data[0].length - 1])
                        .range([0, 500]);

        var yScale = d3.scaleLinear()
                        .domain([d3.min(data.flat()), d3.max(data.flat())])
                        .range([100, 0]);

        var colorScale = d3.scaleOrdinal(d3.schemeCategory10); // Color scale for different lines

        var line = d3.line()
            .x(function(d, i) { return xScale(i); })
            .y(function(d) { return yScale(d); });

        container.selectAll(".line")
            .data(data)
            .enter()
            .append("path")
            .attr("class", "line")
            .attr("d", line)
            .style("stroke", function(d, i) { return colorScale(i); });

        var axis = d3.axisBottom(xScale);

        container.append("g")
            .attr("transform", "translate(0,150)")
            .call(axis);

        console.log(data);

       
                
    </script>
</body>
</html>
