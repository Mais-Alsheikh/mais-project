<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Show all lessons for teacher so they can select one to manage questions
    public function index()
    {
        $lessons = auth()->user()->taughtCourses()->with('lessons')->get()->pluck('lessons')->flatten();
        return view('teacher.questions.index', compact('lessons'));
    }

    // Show questions for a specific lesson
    public function lessonQuestions(Lesson $lesson)
    {
        abort_unless(auth()->user()->id === $lesson->course->teacher_id, 403);
        $questions = $lesson->questions;
        return view('teacher.questions.lesson_index', compact('lesson', 'questions'));
    }

    public function create(Lesson $lesson)
    {
        abort_unless(auth()->user()->id === $lesson->course->teacher_id, 403);
        return view('teacher.questions.create', compact('lesson'));
    }

    public function store(Request $request, Lesson $lesson)
    {
        abort_unless(auth()->user()->id === $lesson->course->teacher_id, 403);

        $data = $request->validate([
            'body' => 'required|string',
            'type' => 'nullable|string',
            'options_raw' => 'nullable|string',
            'correct_answer' => 'nullable|string',
        ]);

        // convert raw options (one per line) to array
        $optionsRaw = $request->input('options_raw');
        $options = $optionsRaw ? array_values(array_filter(array_map('trim', explode("\n", $optionsRaw)))) : null;

        $data['options'] = $options;
        if ($options) {
            $data['type'] = 'mcq';
        }

        $lesson->questions()->create($data);

        return redirect()->route('questions.lesson.index', $lesson->id)->with('success', 'تم إضافة السؤال بنجاح');
    }

    public function edit(Lesson $lesson, Question $question)
    {
        abort_unless(auth()->user()->id === $lesson->course->teacher_id, 403);
        return view('teacher.questions.edit', compact('lesson', 'question'));
    }

    public function update(Request $request, Lesson $lesson, Question $question)
    {
        abort_unless(auth()->user()->id === $lesson->course->teacher_id, 403);

        $data = $request->validate([
            'body' => 'required|string',
            'type' => 'nullable|string',
            'options_raw' => 'nullable|string',
            'correct_answer' => 'nullable|string',
        ]);

        $optionsRaw = $request->input('options_raw');
        $options = $optionsRaw ? array_values(array_filter(array_map('trim', explode("\n", $optionsRaw)))) : null;

        $data['options'] = $options;
        if ($options) {
            $data['type'] = 'mcq';
        }

        $question->update($data);

        return redirect()->route('questions.lesson.index', $lesson->id)->with('success', 'تم تحديث السؤال');
    }

    public function destroy(Lesson $lesson, Question $question)
    {
        abort_unless(auth()->user()->id === $lesson->course->teacher_id, 403);
        $question->delete();
        return back()->with('success', 'تم حذف السؤال');
    }
}
