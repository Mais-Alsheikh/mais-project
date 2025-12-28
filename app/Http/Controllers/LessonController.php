<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        return view('lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf',
            'file' => 'required_if:type,pdf|file|max:10240',
            'video_url' => 'required_if:type,video|url',
        ]);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
        ];

        if ($request->type === 'pdf') {
            $path = $request->file('file')->store('lessons', 'public');
            $data['file_path'] = $path;
            $data['content_path'] = $path;
        } else {
            $data['video_url'] = $request->video_url;
            $data['video_preview'] = $this->getVideoPreview($request->video_url);
        }

        $course->lessons()->create($data);

        return redirect()->route('teacher.dashboard')->with('success', 'تم إضافة الدرس بنجاح!');
    }

    private function getVideoPreview($url)
    {
        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        } elseif (preg_match('/youtu\.be\/([^?]+)/', $url, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        } elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            $data = @file_get_contents("https://vimeo.com/api/v2/video/{$matches[1]}.json");
            if ($data) {
                $json = json_decode($data);
                return $json[0]->thumbnail_large ?? null;
            }
        }
        return null;
    }
}