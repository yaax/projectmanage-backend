<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });

    Route::get('/tasks', function () {
        return response()->json(['tasks'=>Task::orderBy('created_at', 'asc')->get()]);
    });

    /**
     * Add New Task
     */
    Route::post('/tasks', function (Request $request) {
        if (empty($request->task['name'])) {
            return response()->json(['errors'=>"invalid param name"]);
        }

        if (!isset($request->task['status']) || !in_array($request->task['status'],[0,1,'true','false'])) {
            return response()->json(['errors'=>"invalid param status"]);
        }

        $task = new Task;
        $task->name = $request->task['name'];
        $task->status = boolval($request->task['status'])?1:0;

        $task->save();

        return response()->json(['tasks'=>$task]);
    });

    Route::put('tasks/{id}', function(Request $request, $id) {
        if (!is_numeric($id) || (is_numeric($id) && $id<1)) {
            return response()->json(['errors'=>"invalid id"]);
        }

        if (!$request->has('task')) {
            return response()->json(['errors'=>"invalid params"]);
        }

        if (empty($request->task['name'])) {
            return response()->json(['errors'=>"invalid param name"]);
        }

        if (!isset($request->task['status']) || !in_array($request->task['status'],[0,1,'true','false'])) {
            return response()->json(['errors'=>"invalid param status"]);
        }

        $task = Task::where('id', $id)->firstOrFail();

        $task->name = $request->task['name'];
        $task->status = boolval($request->task['status']) ;

        return response()->json([
            'data' => [
                'success' => $task->save(),
            ]
        ]);
    });

    Route::get('/tasks/{id}', function ($id) {
        if (!is_numeric($id) || (is_numeric($id) && $id<1)) {
            return response()->json(['errors'=>"invalid id"]);
        }

        return response()->json(['tasks'=>Task::where('id', $id)->firstOrFail()]);
    });


    /**
     * Delete Task
     */
    Route::delete('/tasks/{id}', function ($id) {
        if (!is_numeric($id) || (is_numeric($id) && $id<1)) {
            return response()->json(['errors'=>"invalid id"]);
        }

        return response()->json([
            'data' => [
                'success' => Task::findOrFail($id)->delete(),
            ]
        ]);
    });
});
