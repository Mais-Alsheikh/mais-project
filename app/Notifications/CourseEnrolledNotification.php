<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CourseEnrolledNotification extends Notification
{
    use Queueable;

    public function __construct(public $course)
    {
    }

    public function via($notifiable)
    {
        return ['database']; // تخزين بقاعدة البيانات
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'تم التسجيل بدورة جديدة',
            'message' => 'تم تسجيلك في دورة: ' . $this->course->title,
        ];
    }
}