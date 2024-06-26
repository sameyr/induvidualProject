    <?php

        $mysqli = require __DIR__ ."/database.php";
        //$username = $_POST['username'];
        //$password = $_POST['password'];
        //$sql="SELECT * from userAuthentication where usernames = '$username' and passwords= '$password'"; 
        //$result = $mysqli -> query($sql);
        //$check = mysqli_fetch_array($result);

        /*if($check == NuLL){
            header("Location: ./login.php?submit=invalidcredentials");
            exit();
        }
        elseif($check[2] == "Teacher"){
            header("Location: ./adminPage.php");
        }
        else{*/
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
        //}
        //}
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="dataSelectionPage.css">
        <!--<link rel="stylesheet" href="https://classless.de/classless.css">-->
    
    </head>
    <body>
        <nav class="navbar">
            <div class="navbar-title">
                <a class="navbar-brand"><b>DATA SELECTION PAGE</b></a>
            </div>

            <div class="signoutBtn-div">
                <button class="signout-btn" onclick="signout()"><b>Sign Out</b></button>
            </div>
        </nav>

        <form action="dataVisualising.php" method="POST">
            <div class="input-form">
                <input type="hidden" id="selectedColumnInput" name="selectedColumn" value="">
                <!-- Dropdown menu with checkboxes to select multiple columns -->
                <div id="list1" class="dropdown-check-list" tabindex="100" >
                    <span class="anchor"required >Select Column</span>
                    <ul class="items">
                            <?php
                                foreach ($columns as $column) {
                                    echo "<label><input type=\"checkbox\" name=\"selectedColumns[]\" value=\"$column\"> $column</label> <br>";
                                }
                            ?>
                    </ul>
                </div>

                <div class="input-time">
                    <div class="startTime">
                        <!-- Input for start timestamp -->
                        <label for="startTimestamp">Start Time:</label>
                        <input type="text" id="startTimestamp" name="startTimestamp" class="startTimeBox" required>
                    </div>
                    
                    <div class="endTime">
                        <!-- Input for end timestamp -->
                        <label for="endTimestamp">End Time:</label>
                        <input type="text" id="endTimestamp" name="endTimestamp" class="endTimeBox" required>
                    </div>
                </div>

                <div class = "error">
                <?php 
                $fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    if(strpos($fullUrl,"submit=starttimegreater") == true){
                        echo "<p class='error'> Error, please try again.<br> End Time is greater than Start Time. <p>";
                    }
                    else if (strpos($fullUrl,"submit=emptyColumn") == true){
                        echo "<p class='error'> Error, please try again.<br> Select appropriate column before submittng. <p>";}
                ?>
                </div>

                <div class="btn-div">
                    <button class = "button" type="submit" name="submit">Submit</button>
                </div>
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
            
            function signout(){
            return location.replace("./login.php");
            }
        </script>
    </body>
    </html>
