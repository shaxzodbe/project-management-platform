<?php

namespace Modules\Task\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Task\Models\Task;

class TaskAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Task $task) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Вам назначена новая задача: ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'task::emails.tasks.assigned',
            with: [
                'task' => $this->task,
            ],
        );
    }
}
