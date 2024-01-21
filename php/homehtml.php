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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://classless.de/classless.css">
</head>
<body>

    <form action="home.php" method="POST">

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

                <!-- Input for start timestamp -->
            <label for="startTimestamp">Start Time:</label>
            <input type="text" id="startTimestamp" name="startTimestamp" required>

            <!-- Input for end timestamp -->
            <label for="endTimestamp">End Time:</label>
            <input type="text" id="endTimestamp" name="endTimestamp" required>

            <!--<label for="timestamp">Timestamp</label>
            <input type="text" id="timestamp" name="timestamp">-->
            
        <div>

        <button type="submit"> Submit </button>
    </form>

</body>

<script>
    var selected_column = null;

    //Event Listner for column selection
    document.getElementById("columnSelect").addEventListener("change",function(){
        selected_column=this.value;

        document.getElementById("selectedColumnInput").value=selected_column; //updating the hidden input field value with the selected column
    })

</script>
</html>