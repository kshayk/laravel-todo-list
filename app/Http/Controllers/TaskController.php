<?php
/**
 * Created by PhpStorm.
 * User: shay
 * Date: 10/26/18
 * Time: 3:30 PM
 */

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index()
    {
        //connect to mysql to get the items

        $tasks = Task::all();

        $items_count = $tasks->count();

        $done_filter = $tasks->filter(function($value, $key) {
            return $value->status === 1;
        });

        $done_count = $done_filter->count();

        return view("main", [
            'items' => $tasks,
            'done_count' => $done_count,
            'remaining_count' => $items_count - $done_count
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200'
        ]);

        $task = new Task();
        $task->name = $request->get("name");
        $task->save();

        $created_at = $task->created_at->toDateTimeString();

        return response()->json(['id' => $task->id, 'created_at' => $created_at]);
    }

    public function updateStatus(Request $request)
    {
        $task = Task::find($request->get("id"));
        $status = ($request->get('status') === "true") ? 1 : 0;

        $task->status = $status;
        $task->save();

        return response()->json('success');
    }

    public function delete(Request $request)
    {
        $task = Task::find($request->get("id"));

        $task->forceDelete();

        return response()->json('success');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'id' => 'required'
        ]);

        $task = Task::find($request->get("id"));
        $task->name = $request->get("name");
        $task->save();

        return response()->json('success');
    }
}
