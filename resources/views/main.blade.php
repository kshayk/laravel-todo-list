<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/main.css">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TO DO list</title>

    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="/js/bootstrap-switch.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="/css/bootstrap-switch.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</head>

<body>
    <div class="text-center">
        <form class="form-inline">
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="Total Tasks">
                <div class="input-group-append">
                    <span id="totalCount" class="input-group-text" style="background-color: black; color:deepskyblue">{{$items->count()}}</span>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="Tasks Completed">
                <div class="input-group-append">
                    <span id="doneCount" class="input-group-text"style="background-color: black; color:lawngreen">{{$done_count}}</span>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" disabled class="form-control" value="Tasks Remaining">
                <div class="input-group-append">
                    <span id="remainingCount" class="input-group-text" style="background-color: black; color:red">{{$remaining_count}}</span>
                </div>
            </div>
    </form>
    </div>

    <div style="margin: 70px">
        <table class="table text-center">
            <thead>
                <tr style="color: white; background-color: #1b1e21">
                    <th scope="col">#</th>
                    <th scope="col">Task Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Done</th>
                    <th scope="col">
                        <button id="addNew" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">Add New Task +</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr data-tr-id="{{$item->id}}">
                        <td>{{$item->id}}</td>
                        <td data-name-id="{{$item->id}}">{{$item->name}}</td>
                        <td>{{$item->created_at}}</td>
                        <td><input type="checkbox" data-id="{{$item->id}}" class="doneCheckbox" {{($item->status === 1) ? "checked" : ""}}></td>
                        <td>
                            <a href="#" title="delete item" class="deleteItem" data-id="{{$item->id}}" data-status="{{$item->status}}"><i class="fas fa-trash-alt"></i></a>
                            &diam;
                            <a href="#" title="edit item" class="updateItem" data-id="{{$item->id}}" data-name="{{$item->name}}" data-toggle="modal" data-target="#updateTaskModal"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{--appending the form modals--}}
    @include('edit-modal');
    @include('new-modal');
</body>

</html>
