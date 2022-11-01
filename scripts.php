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

    
function getTasks($stat){ 
        //CODE HERE
        //SQL SELECT
        // Attempt select query execution
        $conn = connection();
        $sql = "SELECT * FROM tasks JOIN types  ON tasks.type_id=types.idt JOIN priorities ON tasks.priority_id=priorities.idp WHERE status_id='$stat'";
        
        $icon = 'far fa-question-circle';
        if($stat == 2){
            $icon = 'fas fa-circle-notch fa-spin';
        }else if($stat == 3){
            $icon = 'far fa-circle-check';
        }
        
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
                    
                    echo '
                    <button onclick="editTask('.$row['id'].')" class="list-group-item list-group-item-action d-flex" data-bs-toggle="modal" data-bs-target="#modal-task">
                        <div class="me-3 fs-16px">
                            <i class=" '.$icon.' text-green fa-fw"></i> 
                        </div>
                        <div class="flex-fill w-75">
                            <div class="fs-14px lh-12 mb-2px fw-bold text-dark text-truncate">'.$row['title'].'</div>
                            <div class="mb-1 fs-12px">
                                <div class="text-gray-600 flex-1">#'.$row['id'].' created in '.$row['task_datetime'].'</div>
                                <div class="text-gray-900 flex-1 text-truncate" title="'.$row['description'].'">'.$row['description'].'</div>
                            </div>
                            <div class="mb-1">
                                <span class="badge bg-primary">'.$row['namet'].'</span>
                                <span class="badge bg-gray-300 text-gray-900">'.$row['namep'].'</span>
                            </div>
                        </div>
                    </button> ';
                    
                    
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


}


function getSpecificTask($id){
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


function saveTask(){

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


function updateTask(){
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

        $sql = "UPDATE tasks  SET `title`='$title', `type_id`='$type', `priority_id`='$priority', `status_id`='$status', `task_datetime`='$date', `description`='$description' WHERE id = '$update_id'";

        if(mysqli_query($conn, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        mysqli_close($conn);


        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
}


function deleteTask(){
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