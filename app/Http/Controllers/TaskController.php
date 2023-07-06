<?php

namespace App\Http\Controllers;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function storeTask(Request $request) {

        Tasks::create([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
        ]);

        return response()->json(Tasks::latest()->get());
        
    }//
    public function getTask() {
        
        return response()->json(Tasks::latest()->get());
        
    }
    public function updateTask(Request $request, $id) {

        Tasks::where('id', $id)->update([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
        ]);

        return response()->json(Tasks::latest()->get());
        
    }
    public function deleteTask(Request $request, $id) {

        Tasks::where('id', $id)->delete([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
        ]);

        return response()->json(Tasks::latest()->get());
        
    }
}
