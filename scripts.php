<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();
    

    function getTasks()
    {
        //CODE HERE
        //SQL SELECT
        echo "Fetch all tasks";
    }


    function saveTask()
    {

        $mysql = connection();
        //CODE HERE
        $title = $_POST['task-title'];
        $type = $_POST['task-type'];
        $priority = $_POST['priorities-option'];
        $status = $_POST['status-options'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        $sql = "INSERT INTO tasks (`title`, `type_id`, `priority_id`, `status_id`, `task_datetime`, `description`) VALUES ('$title','$type','$priority','$status','$date','$description')";
        $result = $mysql->query($sql);

        if($result == true){
            echo("data added to your database");
        }

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