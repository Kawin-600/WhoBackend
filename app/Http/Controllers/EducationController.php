<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Education;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    // ดึงข้อมูลของผู้ใช้ปัจจุบัน
    public function show()
    {
        $user = Auth::user();
        $education = Education::where('user_id', $user->id)->first();

        return response()->json($education);
    }

    // สร้างข้อมูลใหม่
    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'primary_school' => 'nullable|string|max:255',
            'middle_school'  => 'nullable|string|max:255',
            'high_school'    => 'nullable|string|max:255',
            'university'     => 'nullable|string|max:255',
        ]);

        // ป้องกัน user มีข้อมูลซ้ำ
        $exists = Education::where('user_id', $user->id)->first();
        if ($exists) {
            return response()->json([
                'message' => 'Education info already exists. Use update instead.'
            ], 400);
        }

        $education = Education::create(array_merge($data, ['user_id' => $user->id]));
        return response()->json($education);
    }

    // อัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $education = Education::where('user_id', $user->id)->findOrFail($id);

        $data = $request->validate([
            'primary_school' => 'nullable|string|max:255',
            'middle_school'  => 'nullable|string|max:255',
            'high_school'    => 'nullable|string|max:255',
            'university'     => 'nullable|string|max:255',
        ]);

        $education->update($data);
        return response()->json($education);
    }

    // 🗑 ลบข้อมูลการศึกษา
    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return response()->json([
            'message' => 'Education record deleted successfully'
        ]);
    }
}
