$(document).ready(() => {
    //Saving a newly added task.
    $("#saveChanges").click(() => {
        var taskName = $("#TaskName").val();

        if(taskName === '' || typeof taskName === 'undefined') {
            return alert("missing task name");
        }

        ajaxCall('/add', 'post', {name: taskName}, (res) => {
            //Originally this wasn't the plan but a lot of dynamically added items required a massive refactoring
            //in order for all the events to work properly, so refreshing this page simplified this.
            location.reload();
        });
    });

    //applying the switch mode for every checkbox.
    $(".doneCheckbox").each(function() {
        $(this).bootstrapSwitch({
            'offText': 'To Do',
            'onText': 'Done'
        });

        $(this).bootstrapSwitch('state', $(this).is(":checked"));
    });

    //Switch has changed, update record in DB accordingly
    $('.doneCheckbox').bootstrapSwitch('onSwitchChange', function(event, state) {
        var item_id = $(this).attr('data-id');

        var done = parseInt($("#doneCount").html());
        var remaining = parseInt($("#remainingCount").html());

        ajaxCall('/update-status', 'post', {id: item_id, status: state}, (res) => {
            //Changing the tasks count indicators according to status
            if(state === true) {
                $("#doneCount").html(done + 1);
                $("#remainingCount").html(remaining - 1);
            } else {
                $("#remainingCount").html(remaining + 1);
                $("#doneCount").html(done - 1);
            }
        });
    });

    //deleting an item
    $('.deleteItem').click(function() {
        var item_id = $(this).attr('data-id');
        var item_status = $(this).attr('data-status');

        var confirmDelete = confirm("Are you sure you want to delete this item?");

        if( ! confirmDelete) {
            return false;
        }

        ajaxCall('/delete', 'delete', {'id': item_id}, (res) => {

            $(`[data-tr-id=${item_id}]`).remove();

            $("#totalCount").html(parseInt($("#totalCount").html()) - 1);

            if(item_status === "1") {
                $("#doneCount").html(parseInt($("#doneCount").html()) - 1);
            } else {
                $("#remainingCount").html(parseInt($("#remainingCount").html()) - 1);
            }
        })
    });

    //applying relevant data to the update modal
    $('.updateItem').click(function () {
        var item_id = $(this).attr('data-id');
        var item_name = $(this).attr('data-name');

        $("#taskNameUpdate").val(item_name);
        $("#itemIdUpdate").val(item_id);
    });

    //submitting the updated data in the update modal
    $("#updateChanges").click(() => {
        var taskName = $("#taskNameUpdate").val();
        var taskId = $("#itemIdUpdate").val();

        if(taskName === '' || typeof taskName === 'undefined') {
            return alert("missing task name");
        }

        if(typeof taskId === 'undefined' || taskId === '') {
            return alert("Failed to edit, please try again.");
        }

        ajaxCall('/update-name', 'post', {name: taskName, id: taskId}, () => {
            $(`[data-name-id=${taskId}]`).html(taskName);
        });
    });

    //ajax call helper function
    var ajaxCall = (url, method, data, callback) => {
        $.ajax({
            url: url,
            type: method,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
                callback(data);
            }
        });
    }
})
