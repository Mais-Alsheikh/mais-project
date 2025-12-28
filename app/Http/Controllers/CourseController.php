<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;               //

class CourseController extends Controller
{
    public function create()
        {
            return view('courses.create');
        }

    public function store(Request $request)
        {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
            ]);

            Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'teacher_id' => auth()->id(),
            ]);

            return redirect()->route('teacher.dashboard')
                ->with('success', 'تم إضافة الدورة بنجاح');
        }

    public function myCourses()
        {
            $courses = Course::where('teacher_id', Auth::id())->get();
            return view('teacher.courses', compact('courses'));
        }
    public function index()
        {
            $courses = \App\Models\Course::all();
            return view('courses.index', compact('courses'));
        } 
    
    public function edit(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403);
        }

        return view('teacher.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
        {
            $this->authorize('update', $course);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            $course->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return redirect()->route('teacher.dashboard')
                ->with('success', 'تم تعديل الدورة بنجاح');
        }

    public function destroy(Course $course)
        {
            $this->authorize('delete', $course);
            $course->delete();

            return redirect()->route('teacher.dashboard')
                ->with('success', 'تم حذف الدورة بنجاح');
        }    

}