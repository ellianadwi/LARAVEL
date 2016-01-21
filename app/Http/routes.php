<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Task;
	use Illuminate\Http\Request;

/**
 * Show Task Dashboard
 */
Route::get(	'/', function () {
    return view('tasks', [
    	'tasks' => Task::orderBy('created_at', 'asc')->get()

    ]);
});

/**
 * Detail
 */

Route::get('task/{id}', function ($id){
	return view('detail', [
		'tasks' => Task::find($id)
	]);
});

/**
 * Update
 */

Route::get('update/{id}', function ($id){
	return view('update', [
		'tasks' => Task::find($id)
	]);
});

Route::put('update/{id}',function ($id,request $requirest) {
	$validation = Validator::make($requirest->all(), [
		'name' => 'required|max:255',
		'address' => 'required|max:255',
	]);

	if ($validation->fails()) {
		return redirect('/')
			->withInput()
			->withErrors($validation);
	}
	$task = Task::find($id);
	$task->name = $requirest->name;
	$task->address = $requirest->address;
	$task->save();

	return redirect('/');

});


/**
 * Add New Task
 */
Route::post('/task', function (Request $request) {
	$validator = Validator::make($request->all(), [
		'name' => 'required|max:255',
		'address' => 'required|max:255',
	]);

	if ($validator->fails()) {
		return redirect('/')
			->withInput()
			->withErrors($validator);
	}

	$task = new Task;
	$task->name = $request->name;
	$task->address = $request->address;
	$task->save();

	return redirect('/');
});


/**
 * Delete Task
 */
Route::delete('/task/{id}', function ($id) {
	Task::findOrFail($id)->delete();

	return redirect('/');
});