<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    
// function show(){
//     $servername = "localhost";
//     $username = "username";
//     $password = "password";
//     $dbname = "myDB";

//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);
//     // Check connection
//     if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
//     }

//     $sql = "SELECT id, firstname, lastname FROM MyGuests";
//     $result = $conn->query($sql);
    
//     if ($result->num_rows > 0) {
//     // output data of each row
//     return $result;
//     // while($row = $result->fetch_assoc()) {
//     //     echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//     // }
//     } else {
//     echo "0 results";
//     }
//     $conn->close();
// }
    function getTasks($stat)
    {
        //CODE HERE
        //SQL SELECT
        // Attempt select query execution
        $conn = connection();
        $sql = "SELECT * FROM tasks JOIN types  ON tasks.type_id=types.idt JOIN priorities ON tasks.priority_id=priorities.idp WHERE status_id='$stat'";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                
                while($row = mysqli_fetch_array($result)){
                    echo "<button class='rounded-top'>";
                        echo "<div class='icon'>";
                            echo "<i class='fa-regular fa-circle-question fa-1x'></i>";
                            echo "<i class='fa-solid fa-trash text-danger' id='delete'></i>";
                        echo "</div>";
                        echo "<div class='modal-card text-start' data-bs-toggle='modal' data-bs-target='#exampleModal'>";
                            echo "<div class='title-one'>" . $row['title'] . "</div>";
                            echo "<div class=''>";
                                echo "<div class='creation'><span id='order-card-todo'></span>" . $row['task_datetime'] . "</div>";
                                echo "<div class='having my-1'>" . $row['description'] . "</div>";
                            echo "</div>";
                            echo "<div class='buttons my-1'>";
                                echo "<span class='btn text-white bg-primary'>" . $row['namet'] . "</span>";
                                echo "<span class='btn  bg-light'>" . $row['namep'] . "</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</button>";    
                    
                }
                
                // Free result set
                mysqli_free_result($result);
            } else{
                echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        
        // Close connection
        mysqli_close($conn);


        echo "Fetch all tasks";
}


    function saveTask()
    {

        $conn = connection();
        //CODE HERE
        $title = $_POST['task-title'];
        $type = $_POST['task-type'];
        $priority = $_POST['priorities-option'];
        $status = $_POST['status-options'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        $sql = "INSERT INTO tasks (`title`, `type_id`, `priority_id`, `status_id`, `task_datetime`, `description`) VALUES ('$title','$type','$priority','$status','$date','$description')";
        // $result = mysqli_query($conn, $sql)

        // if($result == true){
        //     echo "data added to your database";
        // }

        if(mysqli_query($conn, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        mysqli_close($conn);

        //SQL INSERT
        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
}

    function updateTask()
    {
        //CODE HERE
        //SQL UPDATE
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
}

    function deleteTask()
    {
        //CODE HERE
        //SQL DELETE
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
}

?>