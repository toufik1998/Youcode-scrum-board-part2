document.querySelector("#addButton").addEventListener("click", ()=>{
    clearForm();

    document.querySelector("#task-save-btn").style.display = 'block';
    document.querySelector("#task-delete-btn").style.display = 'none';
    document.querySelector("#task-update-btn").style.display = 'none';
});


function editTask(id){
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

    document.querySelector("#task-save-btn").style.display = 'none';
    document.querySelector("#task-delete-btn").style.display = 'block';
    document.querySelector("#task-update-btn").style.display = 'block';
}

function clearForm(){
    document.querySelector("#task-id").value = '';
    document.querySelector("#task-title").value = '';
    document.querySelector("#task-type-2").checked = true;
    document.querySelector("#task-priority").value = '1';
    document.querySelector("#task-status").value = '1';
    document.querySelector("#task-date").value = '';
    document.querySelector("#task-description").value = '';
}

function deleteTask(){
    if(confirm('Do you want delete this Task : ') == true){
        document.querySelector("#buttonDelete").click();
    }
}