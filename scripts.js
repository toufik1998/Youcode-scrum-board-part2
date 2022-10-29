function searchTask(id){
    document.querySelector("#task-id").value = id;
	console.log(id);

    $.ajax({
        type: "POST",
        url: 'scripts.php',
        data: {openTask : id},
        success: function (obj) {
            console.log(obj);
            document.getElementById('task-title').value                                     = obj[0];
            document.getElementById("task-type-"+obj[1]).checked                            = true;
            document.getElementById('task-priority').value                                  = obj[2];
            document.getElementById('task-status').value                                    = obj[3];
            document.getElementById('task-date').value                                      = obj[4];
            document.getElementById('task-description').value                               = obj[5];
        }
    });
}           