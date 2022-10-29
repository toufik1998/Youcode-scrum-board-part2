<?php

    
    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    if(isset($_POST['openTask']))    getSpecificTask($_POST['openTask']);

    
    function getTasks($stat)
    { 
        //CODE HERE
        //SQL SELECT
        // Attempt select query execution
        $conn = connection();
        $sql = "SELECT * FROM tasks JOIN types  ON tasks.type_id=types.idt JOIN priorities ON tasks.priority_id=priorities.idp WHERE status_id='$stat'";
        if($result = mysqli_query($conn, $sql)){
            if($stat == 1){
                $_SESSION['todo'] = mysqli_num_rows($result);

            }else if($stat == 2){
                $_SESSION['progresse']  = mysqli_num_rows($result);
            }else{
                $_SESSION['done'] = mysqli_num_rows($result);
            }
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    echo "<button class='border-white border-0 mt-2' onclick='searchTask(".$row['id'].")' data-bs-toggle='modal' data-bs-target='#modal-task'>";
                        // if($stat == 1){
                        //     echo "<i class='fa-solid fa-trash text-danger' id='delete'></i>";
                        // }else{
                        //     echo "<i class='fa-solid fa-pen' data-bs-toggle='modal' data-bs-target='#edit-modal-task'></i>";
                        // }

                        echo "<div class='text-start' >";
                            echo "<div class='title-one'>" . $row['title'] . "</div>";
                            echo "<div class=''>";
                                echo "<div class='creation'><span id='order-card-todo'></span>" . $row['task_datetime'] . "</div>";
                                echo "<div class='having my-1'>" . $row['description'] . "</div>";
                            echo "</div>";
                            echo "<div class='buttons my-1 d-flex justify-content-between align-items-center'>";
                                echo "<span class='btn text-white bg-primary'>" . $row['namet'] . "</span>";
                                echo "<span class='btn  bg-light border-info'>" . $row['namep'] . "</span>";
                            echo "</div>";

                        echo "</div>";
                    echo "</button>";  
                    
                    
                    // $_SESSION['progresse']++;$_SESSION['todo']++;
                    // $_SESSION['done']++;
                    
                }
                // Return the number of rows in result set
                $rowcount=mysqli_num_rows($result);
                printf("Result set has %d rows.\n",$rowcount);
                
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


        // echo "Fetch all tasks";
}

function getSpecificTask($id)
    {
        header('Content-Type: application/json');
        $aResult = [];
        // CODE HERE
        // SQL SELECT
        $link = connection();

        $sql = "SELECT * FROM tasks where id = $id";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $aResult[0] = $row['title'];
                    $aResult[1] = $row['type_id'];
                    $aResult[2] = $row['priority_id'];
                    $aResult[3] = $row['status_id'];
                    $aResult[4] = $row['task_datetime'];
                    $aResult[5] = $row['description'];
                }
                // Free result set
                mysqli_free_result($result);
            }
        }

        // Close connection
        mysqli_close($link);
        echo json_encode($aResult);
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
        $conn = connection();
        //CODE HERE
        $update_id = $_POST['task-id'];
        $title = $_POST['task-title'];
        $type = $_POST['task-type'];
        $priority = $_POST['priorities-option'];
        $status = $_POST['status-options'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        $sql = "UPDATE tasks  SET `title`='$title', `type_id`='$type', `priority_id`='$priority', `status_id`='$status', `task_datetime`='$date', `description`='$description' WHERE id = $update_id";

        if(mysqli_query($conn, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        mysqli_close($conn);


        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
}

    function deleteTask()
    {
        //CODE HERE
        //SQL DELETE
        $conn = connection();
        $id = $_POST["task-id"];

        $sql = "DELETE FROM tasks where id = $id";

        if(mysqli_query($conn, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        mysqli_close($conn);
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
}



?>