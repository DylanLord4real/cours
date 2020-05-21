<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class ApiController extends Controller
{
    public function getAllStudents(){
        //Selectionner tout les élèves
        $students = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
    }
    public function createStudent(Request $requete){
        //creation d'un élève
        $student = new Student;
        $student->name = $requete->name;
        $student->course = $requete->course;
        $student->save();

        return response()->json([
            "message" => "Student record created"
        ], 201);
    }
    public function getStudent($id){
        //Selection d'un etudianr
        if(Student::where('id', $id)->exists()){
            $student = Student::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($student, 200);
        }else{
            return response()->json([
                "message" => "Student not found"
            ], 400);
        }
    }
    public function updateStudent(Request $requete, $id){
        //mise a jour
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;
            $student->save();
            return response()->json([
            "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
            "message" => "Student not found"
            ], 404);
        }
    }
    public function deleteStudent($id){
        //suppression d'un élèves
        if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();
            return response()->json([
                "message" => "records deleted"
            ], 202);
            } else {
                return response()->json([
                    "message" => "Student not found"
                ], 404);
                }
            }
}
