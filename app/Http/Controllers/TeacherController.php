<?php
/* for update teacher */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{

    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }

        $teacher->update([
            'full_name' => $request->full_name,
            'name_with_initial' => $request->name_with_initial,
            'nic' => $request->nic,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
        ]);

        return response()->json([
            "message" => "Teacher updated successfully"
        ]);
    }

}


