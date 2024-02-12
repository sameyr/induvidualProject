    <?php

        //if(($_POST['username'] == "samir") && ($_POST['password'] == "shrestha") ){
            $mysqli = require __DIR__."/database.php";
            $error_message  = '';

        /* if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                if((empty($_POST["startTimestamp"])) || (empty($_POST["endTimestamp"]))){
                    die("Error, please enter proper value in timestamp box.");
                }    
                

                if ((strtotime($_POST["endTimestamp"])) <  (strtotime($_POST["startTimestamp"]))){
                    die("Error, please try again.<br> End Time is greater than Start Time.");
                }
            }
            if (empty($error_message)){*/
                
                
                    //Retriving Column name from database
                    $tableName ='sampleinputdata';
                    $query ="SHOW COLUMNS FROM $tableName";
                    $result = $mysqli->query($query);


                    //creating empty array and populating array using result 
                    $coulmns = [];
                    while ($row = $result -> fetch_assoc()){
                        $columns[] = $row['Field']; 
                    }
                //}    
        //else{
        //    die("wrong credential");
        //}

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="dataSelectionPage.css">
        <link rel="stylesheet" href="https://classless.de/classless.css">
    
    </head>
    <body>

        <form action="dataVisualising.php" method="POST">
        <div class="input-form">
            <input type="hidden" id="selectedColumnInput" name="selectedColumn" value="">

            <!-- Dropdown menu with checkboxes to select multiple columns -->
            <div id="list1" class="dropdown-check-list" tabindex="100">
                <span class="anchor" >Select Column</span>
                <ul class="items">
                        <?php
                            foreach ($columns as $column) {
                                echo "<label><input type=\"checkbox\" name=\"selectedColumns[]\" value=\"$column\"> $column</label> <br>";
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
                <button type="submit" name="submit">Submit</button>
            </div>
            <?php 
            $fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                if(strpos($fullUrl,"submit=starttimegreater") == true){
                    echo "<p class='error'> Error, please try again.<br> End Time is greater than Start Time. <p>";
                }
                else if (strpos($fullUrl,"submit=emptyColumn") == true){
                    echo "<p class='error'> Error, please try again.<br> Select appropriate column before submittng. <p>";}
            ?>
        </div>
        </form>

        <script>

            var selectedColumns = [];

            // adding checkmark according to user selection
            var checkList = document.getElementById('list1');
            checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
                if (checkList.classList.contains('visible'))
                    checkList.classList.remove('visible');
                else
                    checkList.classList.add('visible');
                    selectedColumns = Array.from(document.querySelectorAll('input[name="selectedColumns[]"]:checked'))
                                                .map(function(checkbox) {
                                                    return checkbox.value;
                                                });
                    console.log(selectedColumns);
                    document.getElementById("selectedColumnInput").value = selectedColumns.join(",");
                }
        </script>
    </body>
    </html>
