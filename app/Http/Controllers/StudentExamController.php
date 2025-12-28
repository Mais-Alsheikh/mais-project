<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    // List exams available for student's enrolled courses
    public function index()
    {
        $user = auth()->user();
        $exams = Exam::whereIn('course_id', $user->courses()->pluck('courses.id'))->with('course')->get();
        return view('student.exams.index', compact('exams'));
    }

    // Show exam (take) page
    public function show(Exam $exam)
    {
        $user = auth()->user();
        abort_unless($user->courses()->where('course_id', $exam->course_id)->exists(), 403);

        // load questions and pivot points
        $exam->load(['questions' => function($q){ $q->orderBy('exam_question.position'); }]);

        return view('student.exams.show', compact('exam'));
    }

    // Submit answers and grade
    public function submit(Request $request, Exam $exam)
    {
        $user = auth()->user();
        abort_unless($user->courses()->where('course_id', $exam->course_id)->exists(), 403);

        $data = $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $data['answers']; // expected: ['question_id' => 'answer_value']

        // load questions with pivot
        $questions = $exam->questions()->get();

        $totalPoints = 0;
        $earned = 0;
        $detailed = [];

        foreach ($questions as $q) {
            $points = intval($q->pivot->points ?? 1);
            $totalPoints += $points;

            $submitted = isset($answers[$q->id]) ? trim((string)$answers[$q->id]) : null;
            $correct = false;

            if ($q->type === 'mcq') {
                // compare trimmed strings (case-insensitive)
                if ($submitted !== null && strcasecmp($submitted, trim((string)$q->correct_answer)) === 0) {
                    $earned += $points;
                    $correct = true;
                }
            } else {
                // text questions not auto-graded (could be graded later)
                $correct = null; // unknown
            }

            $detailed[$q->id] = [
                'submitted' => $submitted,
                'correct' => $correct,
                'points' => $points,
            ];
        }

        $percentage = $totalPoints ? round(($earned / $totalPoints) * 100, 2) : 0;

        $result = ExamResult::create([
            'exam_id' => $exam->id,
            'user_id' => $user->id,
            'answers' => $detailed,
            'score' => $earned,
            'percentage' => $percentage,
            'started_at' => now(),
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.exams.result', ['exam' => $exam->id, 'result' => $result->id]);
    }

    public function result(Exam $exam, ExamResult $result)
    {
        $user = auth()->user();
        abort_unless($result->user_id === $user->id && $result->exam_id === $exam->id, 403);
        $result->load('exam');
        return view('student.exams.result', compact('exam', 'result'));
    }
}
