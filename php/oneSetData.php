<?php
    $mysqli = require __DIR__."/database.php";

    //Retriving Column name from database
    $tableName ='sampleinputdata';
    $query ="SHOW COLUMNS FROM $tableName";
    $result = $mysqli->query($query);


    //creating empty array and populating array using result 
    $coulmns = [];
    while ($row = $result -> fetch_assoc()){
        $columns[] = $row['Field']; 
    }

    // Retrieve distinct timestamps from the database
    $timestampQuery = "SELECT DISTINCT timestamp FROM $tableName";
    $timestampResult = $mysqli->query($timestampQuery);

    $timestamps = [];
    while ($row = $timestampResult->fetch_assoc()) {
        $timestamps[] = $row['timestamp'];
    }


?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://classless.de/classless.css">
</head>
<body>

    <form action="oneSetDataVisual.php" method="POST">

        <input type="hidden" id = "selectedColumnInput" name="selectedColumn" value ="">
        
        <!-- Dropdown menu to select column -->
        <label for="columnSelect">Select Column:</label>
            <select id="columnSelect">
                <?php
                    foreach ($columns as $column) {
                        echo "<option value=\"$column\">$column</option>";
                    }
                ?>
            </select>                
        
        <div>
            <input type="hidden" id = "selectedStartTimeInput" name="startTimestamp" value ="">
            <label for="startTimestamp">Select Timestamp:</label>
            <select id="startTimestamp">
                <?php
                    foreach ($timestamps as $timestamp) {
                        echo "<option value=\"$timestamp\">$timestamp</option>";
                    }
                ?>
            </select>

            <!-- Input for end timestamp -->
            <div>
            <input type="hidden" id = "selectedEndTimeInput" name="endTimestamp" value ="">
            <label for="endTimestamp">Select Second Timestamp:</label>
            <select id="endTimestamp" >
            <?php
                    foreach ($timestamps as $timestamp) {
                        echo "<option value=\"$timestamp\">$timestamp</option>";
                    }
                ?>
            </select>
        </div>

            <!--<label for="timestamp">Timestamp</label>
            <input type="text" id="timestamp" name="timestamp">-->
            
        <div>

        <button type="submit"> Submit </button>
    </form>

</body>

<script>
    var selected_column = null;
    var selected_start = null;
    var selected_end = null;
    
    //Event Listner for column selection
    document.getElementById("columnSelect").addEventListener("change",function(){
        selected_column=this.value;
        
        document.getElementById("selectedColumnInput").value=selected_column; //updating the hidden input field value with the selected column
    })

    
    // Event listener for timestamp selection
    document.getElementById("startTimestamp").addEventListener("change", function () {
        // Get the selected timestamp
        selected_start = this.value;
        document.getElementById("selectedStartTimeInput").value=selected_start;

    })

    document.getElementById("endTimestamp").addEventListener("change", function () {
        // Get the selected timestamp
        selected_end = this.value;
        document.getElementById("selectedEndTimeInput").value=selected_end;

    })

</script>
</html>