<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
            'tel'        => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'department' => 'nullable|string|max:255',
        ]);

        $student = Student::updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['first_name','last_name','address','tel','birth_date','department'])
        );

        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->where('id', $id)->first();

        if (! $student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'nullable|string|max:255',
            'tel'        => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'department' => 'nullable|string|max:255',
        ]);

        $student->update($request->only(['first_name','last_name','address','tel','birth_date','department']));

        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

}