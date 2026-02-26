<?php
// for create, list, freeze, block
namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminTeacherController extends Controller
{
    // CREATE TEACHER
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'name_with_initial' => 'required',
            'nic' => 'required|unique:teachers',
            'email' => 'required|email|unique:teachers',
            'phone' => 'required',
            'whatsapp' => 'required'
        ]);

        // ✅ Generate teacher_code using MAX ID (PROFESSIONAL METHOD)
        $lastId = Teacher::max('id') ?? 0;
        $nextId = $lastId + 1;

        $teacherCode = 'TCH' . str_pad($nextId, 4, '0', STR_PAD_LEFT);


        $teacher = Teacher::create([
            'teacher_code' => $teacherCode,
            'full_name' => $request->full_name,
            'name_with_initial' => $request->name_with_initial,
            'nic' => $request->nic,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
        ]);

        
        

        $password = Str::random(8);

        User::create([
            'username' => $request->email,
            'password' => Hash::make($password),
            'role' => 'teacher',
            'teacher_id' => $teacher->id
        ]);

        Mail::raw(
            "Your LMS login password is: $password",
            fn ($msg) => $msg->to($teacher->email)->subject('LMS Login Details')
        );

        return response()->json([
            'message' => 'Teacher created successfully']);
    }

    // LIST TEACHERS
    public function index()
    {
        return Teacher::all();
    }

    // FREEZE TEACHER
    public function freeze($id)
    {
        Teacher::where('id', $id)->update(['status' => 'frozen']);
        return response()->json(['message' => 'Teacher frozen']);
    }

    // UNFREEZE TEACHER
    public function unfreeze($id)
    {
        Teacher::where('id', $id)->update(['status' => 'active']);
        return response()->json(['message' => 'Teacher activated']);
    }

    public function updateStatus(Request $request, $id)
    {
        $teacher = \App\Models\Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }

        $teacher->status = $request->status;
        $teacher->save();

        return response()->json([
            "message" => "Status updated successfully"
        ]);
    }

    //Delete Teacher
    public function destroy($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                "message" => "Teacher not found"
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            "message" => "Teacher deleted successfully"
        ]);
    }
}
