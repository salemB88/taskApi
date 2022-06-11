<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
 public function uploade(Request $request,$taskID){
$user =auth()->user();
     $validation=$request->validate([
        'file'=>'required|max:5000|mimes:jpeg',
     ]);

     $taskModel=Task::findOrFail($taskID);
     if($user->id!=$taskModel->user_id){
         return response()->json(['message'=>'Error not Auth',401]);
     }else {

$fileName=$request->file('file')->hashName();
$uploaded=$request->file('file')->storeAs('public/tasks/'.$taskID,$fileName);

if($uploaded){
    $fileData=['user_id'=>$user->id,'name'=>$fileName];
    $saveFile=$taskModel->Files()->create($fileData);

    if($saveFile){
     return  $saveFile;
    }

}else {
    return response()->json(['message'=>'Error Please Try again',500]);
}




     }




 }


 public function destroy(File $file){
if(auth()->user()->id!=$file->user_id){
    return response()->json(['message' => 'Error not Auth'], 401);
}else{
    $deleted=Storage::delete('public/tasks/'.$file->task_id.'/'.$file->name);
    if($deleted){
        return response()->json(['message' => 'File deleted Successful']);

    }
    return response()->json(['message' => 'Error try again'], 500);


}

 }
}
