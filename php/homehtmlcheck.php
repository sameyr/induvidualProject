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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://classless.de/classless.css">
    <style>
        .dropdown-check-list {
        display: inline-block;
        }

        .dropdown-check-list .anchor {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding: 5px 50px 5px 10px;
        border: 1px solid #ccc;
        }

        .dropdown-check-list .anchor:after {
        position: absolute;
        content: "";
        border-left: 2px solid black;
        border-top: 2px solid black;
        padding: 5px;
        right: 10px;
        top: 20%;
        -moz-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        -o-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
        }

        .dropdown-check-list .anchor:active:after {
        right: 8px;
        top: 21%;
        }

        .dropdown-check-list ul.items {
        padding: 2px;
        display: none;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
        }

        .dropdown-check-list ul.items li {
        list-style: none;
        }

        .dropdown-check-list.visible .anchor {
        color: #0094ff;
        }

        .dropdown-check-list.visible .items {
        display: block;
        }
    </style>
</head>
<body>

    <form action="home.php" method="POST">

        <input type="hidden" id="selectedColumnInput" name="selectedColumn" value="">

        <!-- Dropdown menu with checkboxes to select multiple columns -->
        <div id="list1" class="dropdown-check-list" tabindex="100">
            <span class="anchor" >Select Column</span>
            <ul class="items">
                    <?php
                        foreach ($columns as $column) {
                            echo "<label><input type=\"checkbox\" name=\"selectedColumns[]\" value=\"$column\"> $column</label>";
                        }
                    ?>
            </ul>
        </div>

        <div>
            <!-- Input for start timestamp -->
            <label for="startTimestamp">Start Time:</label>
            <input type="text" id="startTimestamp" name="startTimestamp" required>

            <!-- Input for end timestamp -->
            <label for="endTimestamp">End Time:</label>
            <input type="text" id="endTimestamp" name="endTimestamp" required>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>

    <script>

        var selected_column = [];

        // Event listener for column selection
        var checkList = document.getElementById('list1');
        checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
            if (checkList.classList.contains('visible'))
                checkList.classList.remove('visible');
            else
                checkList.classList.add('visible');
                selected_column = this.value;
            }
            
        document.getElementById("selectedColumnInput").value = selected_column;
    </script>
</body>
</html>
