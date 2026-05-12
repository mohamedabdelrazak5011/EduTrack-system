<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Center;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeMode;
use Maatwebsite\Excel\Facades\Excel;


class StudentController extends Controller
{
    /* ======================================================
       عرض كل الطلاب
    ====================================================== */




    public function destroy(Request $request, $id)
    {
        // التحقق من الباسورد الثابت
        if ($request->password !== '123') {
            return back()->withErrors(['password' => 'Wrong password']);
        }

        // البحث عن الطالب وحذفه
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:students,name',
            'parent_phone' => 'required|string|unique:students,parent_phone',
            'center_id' => 'required|exists:centers,id',
            'photo' => 'nullable|image',
        ], [
            'name.unique' => 'هذا الطالب موجود بالفعل',
            'parent_phone.unique' => 'رقم ولي الأمر مستخدم بالفعل',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/students'), $photoName);
        }

        Student::create([
            'name' => $request->name,
            'parent_phone' => $request->parent_phone,
            'phone' => $request->phone,
            'center_id' => $request->center_id,
            'student_code' => 'STD-' . strtoupper(Str::random(6)),
            'photo' => $photoName,
            'national_id' => $request->national_id,
            'email' => $request->email,
            'grade' => $request->grade,
            'birth_date' => $request->birth_date,
            'notes' => $request->notes,

            'gender' => $request->gender,   // ✔️ مهم
            'status' => $request->status ?? 'active', // ✔️ مهم
        ]);

        return redirect()->route('students.index')
            ->with('success', '✅ تم إضافة الطالب بنجاح');

    }
    public function index(Request $request)
    {
        $students = Student::with('center')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('student_code', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('parent_phone', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('students.index', compact('students'));
    }
    public function create()
    {
        $centers = Center::all();

        return view('students.create', compact('centers'));
    }
    public function show($id)
    {
        $student = Student::with('center')->findOrFail($id);

        return view('students.profile', compact('student'));

    }
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $centers = Center::all();

        return view('students.edit', compact('student', 'centers'));
    }
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $student->update([
            'name' => $request->name,
            'parent_phone' => $request->parent_phone,
            'center_id' => $request->center_id,
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Updated successfully');
    }
    public function qr($student)
    {
        $student = Student::findOrFail($student);

        $data = $student->student_code;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->build();

        $fileName = $student->name . '-' . $student->student_code . '.png';

        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
