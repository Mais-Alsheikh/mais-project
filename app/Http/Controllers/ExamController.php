<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    // List exams for the current teacher
    public function index()
    {
        $exams = Exam::whereHas('course', function($q){
            $q->where('teacher_id', auth()->id());
        })->with('course')->get();

        return view('teacher.exams.index', compact('exams'));
    }

    // Show form to create an exam (do NOT fetch questions here)
    public function create(Request $request)
    {
        $courses = auth()->user()->taughtCourses()->get();
        // Note: don't fetch questions here — questions will be selected after the exam is created
        return view('teacher.exams.create', compact('courses'));
    }

    // Store exam, then redirect to manage questions for that exam
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        // ensure course belongs to teacher
        $course = Course::where('id', $data['course_id'])->where('teacher_id', auth()->id())->first();
        abort_unless($course, 403);

        $exam = Exam::create([
            'course_id' => $course->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'duration_minutes' => $data['duration_minutes'] ?? null,
        ]);

        // After creating the exam, redirect to the manage-questions page where teacher can select questions
        return redirect()->route('exams.questions.manage', $exam->id)->with('success', 'تم إنشاء النموذج الامتحاني، الآن اختر الأسئلة');
    }

    public function show(Exam $exam)
    {
        abort_unless($exam->course->teacher_id === auth()->id(), 403);
        $exam->load('questions');
        return view('teacher.exams.show', compact('exam'));
    }

    // Show/manage questions for an exam (attach/detach)
    public function manageQuestions(Exam $exam)
    {
        abort_unless($exam->course->teacher_id === auth()->id(), 403);

        // fetch questions that belong to the exam's course
        $questions = $exam->course->lessons()->with('questions')->get()->pluck('questions')->flatten();
        $selected = $exam->questions()->pluck('questions.id')->toArray();

        return view('teacher.exams.manage_questions', compact('exam', 'questions', 'selected'));
    }

    // Update questions attached to exam
    public function updateQuestions(Request $request, Exam $exam)
    {
        abort_unless($exam->course->teacher_id === auth()->id(), 403);

        $data = $request->validate([
            'questions' => 'nullable|array',
            'questions.*' => 'integer|exists:questions,id',
        ]);

        $validQuestionIds = [];
        if (!empty($data['questions'])) {
            $validQuestionIds = Question::whereIn('id', $data['questions'])
                ->whereHas('lesson', function($q) use ($exam) {
                    $q->where('course_id', $exam->course_id);
                })->pluck('id')->toArray();
        }

        // Build attach data with default points and positions
        $attachData = [];
        $position = 1;
        foreach ($validQuestionIds as $qid) {
            $attachData[$qid] = ['points' => 1, 'position' => $position++];
        }

        $exam->questions()->sync($attachData);

        return redirect()->route('exams.show', $exam->id)->with('success', 'تم تحديث أسئلة النموذج');
    }

    public function destroy(Exam $exam)
    {
        abort_unless($exam->course->teacher_id === auth()->id(), 403);
        $exam->delete();
        return back()->with('success', 'تم حذف النموذج الامتحاني');
    }
}
