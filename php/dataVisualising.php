    <?php

        if((empty($_POST["startTimestamp"])) || (empty($_POST["endTimestamp"]))){
            header("Location: ./dataSelectionPage.php?submit=emptytimestamp");
            exit();
        }  

        if(empty($_POST["selectedColumn"])){
            header("Location: ./dataSelectionPage.php?submit=emptyColumn");
            exit();
        }    

        if ((strtotime($_POST["endTimestamp"])) <  (strtotime($_POST["startTimestamp"]))){
            header("Location: ./dataSelectionPage.php?submit=starttimegreater");
            exit();
            //die("Error, please try again.<br> End Time is greater than Start Time.");
        }

        $mysqli = require __DIR__ ."/database.php";
        
        $selectedColumn =$mysqli -> real_escape_string($_POST["selectedColumn"]);
        
        $startTime= $_POST["startTimestamp"];
        $endTime=$_POST["endTimestamp"];

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
        
        
        //echo $sql . "<br>";                    
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
        /*foreach ($columnData as $column => $data) {
            echo "<br>$column:<br>";
            foreach ($data as $value) {
                echo  "Value: " . $value . "<br>";
            }
            echo "<br>";
        }*/

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://d3js.org/d3.v4.js"></script>
        <link rel="stylesheet" href="dataVisualisation.css">
    </head>
    <body>

        <nav class="navbar">
                <div class="navbar-title">
                    <a class="navbar-brand"><b>DATA VISUALISATION PAGE</b></a>
                </div>

                <div class="signoutBtn-div">
                    <button class="back-btn" onclick="location = 'dataSelectionPage.php'"><b>Back</b></button>
                    <button class="signout-btn" onclick="signout()"><b>Sign Out</b></button>
                </div>
        </nav>

     
        <script>

            function signout(){
                return location.replace("./login.php");
            }

            // Encode $columnData as an indexed array before outputting
            var columnData =<?php echo json_encode($columnData); ?>;
        
            //Extracting all the column name and storing it in an array
            var columns = Object.keys(columnData);

            // Extracting the values from the selected columns
            var data = columns.map(function(columns) {
                return columnData[columns];
            });   
          
             //adding a legend
             var legendData = columns;

            var colorScale = d3.scaleOrdinal(d3.schemeCategory10); // Color scale for different lines

            var xScale = d3.scaleLinear()
                            .domain([0, data[0].length - 1])
                            .range([0, 600]);

            var yScale = d3.scaleLinear()
                            .domain([d3.min(data.flat()), d3.max(data.flat())])
                            .range([250, 10]);


            //adding css to the graph
            var containerDiv=d3.select("body")
                    .append("div")
                    .style("position","relative")
                    .style("text-align" , "center")
                    .style("background-color","white")
                    .style("margin","25px 30px 30px")
                    .style("border","none")
                    .style("border-radius","25px")
                    .style("box-shadow"," 0 2px 4px rgba(0, 0, 0, .1), 0 8px 16px rgba(0, 0, 0, .1)"); 

            //makin a svg container for the graph 
            var container = containerDiv.append("svg")
                .attr("height", 500)
                .attr("width", 700)
                .append("g")
                .attr("transform", "translate(130,100)");

             //Adding gridlines
             container.selectAll(".grid-line")
                .data(yScale.ticks(5))
                .enter().append("line")
                .attr("class", "grid-line")
                .attr("x1", 0)
                .attr("x2", 600) // width of the graph
                .attr("y1", d => yScale(d))
                .attr("y2", d => yScale(d))
                .style("stroke", "#ddd") // Grid line color

            // Adding vertical gridlines
            container.selectAll(".vertical-grid-line")
                .data(xScale.ticks(5)) // number of ticks
                .enter().append("line")
                .attr("class", "vertical-grid-line")
                .attr("x1", d => xScale(d)) //calling scale function
                .attr("x2", d => xScale(d))
                .attr("y1", 0)
                .attr("y2", 270) //  height of the graph
                .style("stroke", "#ddd") // Grid line color


            // Creating legend
            var legend = containerDiv.append("div")
                .attr("class", "legend")
                .style("position", "absolute")
                .style("top", "20px") 
                .style("right", "20px") 
                .style("text-align", "left")
                .style("border","solid")
                .style("border-radius","7px")
                .style("border-width","2px")
                .style("padding","3px 8px 3px 2px")
                .style("border-color","grey");


            // Add legend items
            legend.selectAll(".legend-item")
                .data(legendData)
                .enter().append("div")
                .attr("class", "legend-item")
                .style("display", "flex")
                .style("align-items", "center")
                .style("margin-left", "20px")
                .style("margin-bottom", "5px")
                .each(function(d, i) {
                    var legendItem = d3.select(this);
                    legendItem.append("div")
                        .style("width", "10px")
                        .style("height", "10px")
                        .style("background-color", colorScale(i))
                        .style("margin-right", "15px");
                    legendItem.append("div")
                        .text(d);
                });       

            var line = d3.line()
                .x(function(d, i) { return xScale(i); })
                .y(function(d) { return yScale(d); });

            // Add tooltip
            const tooltip = containerDiv.append("div")
            .attr("class", "tooltip")
            .style("opacity", 0); // Initially hidden 
                
            container.selectAll(".line")
                .data(data)
                .enter()
                .append("path")
                .attr("class", "line")
                .attr("d", line)
                .style("stroke", function(d, i) { return colorScale(i); })
                .style("fill", "none")
                .style("stroke", "rgb(51, 102, 204)")
                .style("stroke-width","2")
                .on("mouseover", function(d, i) {
                d3.select(this).style("cursor", "pointer");
                // Shows tooltip on hover
                tooltip.transition()
                    .duration(100)
                    .style("opacity", .9);
                // Extract x and y values of the hovered point
                var mouseX = d3.mouse(this)[0];
                var mouseY = d3.mouse(this)[1];
                var xValue = xScale.invert(mouseX);
                var yValue = yScale.invert(mouseY);
                // Positioniing tooltip near the mouse pointer
                tooltip.html("X: " + xValue.toFixed(2) + "<br>Y: " + yValue.toFixed(2));
                })    
                .on("mouseout", function(d) {
                // Hiding tooltip on mouseout
                tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                });

            // adding x-axis
            container.append("g")
                .attr("transform", "translate(0,250)")
                .call(d3.axisBottom(xScale));
                 
            //adding y-axis
            container.append("g")
                .call(d3.axisLeft(yScale));

              // Add x-axis label
              container.append("text")
                .attr("class", "x-axis-label")
                .attr("x", 275)
                .attr("y", 290) // Adjust the position as needed
                .attr("text-anchor", "middle")
                .text("Array Index")
                .style("font-size","13px");

            // Add y-axis label
            container.append("text")
                .attr("class", "y-axis-label")
                .attr("transform", "rotate(-90)") // Rotate the label to make it vertical
                .attr("x", -125)
                .attr("y", -60) // Adjust the position as needed
                .attr("dy", "1em")
                .attr("text-anchor", "middle")
                .text(legendData)
                .style("font-size","13px");
        
        </script>

        <form action="export.php" method="POST">
            <div class="download-list">
                <input type="hidden" id="startTimeStamp" name ="startTimeStamp" value="<?php echo $startTime?>" >
                <input type="hidden" id="endTimeStamp" name="endTimeStamp" value= "<?php echo $endTime?>" >
                <input type="hidden" id="selectedDownloadColumn" name="selectedDownloadColumn" value="">
                    <div id="list1" tabindex="100">
                        <span class="anchor" >Select column to download</span>
                        <ul class="items">
                            <?php
                                foreach ($selectedColumnArray as $column) {
                                    echo "<label><input type=\"checkbox\" name=\"selectedColumns[]\" value=\"$column\"> $column</label> <br>";
                                }
                            ?>
                        </ul>
                    </div>
                <button class="download-btn" type="submit" name="submit">Download</button>
            </div>
        </form>
        
        <script>
            var selectedColumns = [];
           // adding checkmark according to user selection
           var checkList = document.getElementById('list1');
            checkList.getElementsByClassName('items')[0].onclick = function(evt) {
                if (checkList.classList.contains('visible'))
                    checkList.classList.remove('visible');
                else
                    checkList.classList.add('visible');
                    selectedColumns = Array.from(document.querySelectorAll('input[name="selectedColumns[]"]:checked'))
                                                .map(function(checkbox) {
                                                    return checkbox.value;
                                                });
                    console.log(selectedColumns);
                    document.getElementById("selectedDownloadColumn").value = selectedColumns.join(",");
                }
        </script>

    </body>
    </html>
