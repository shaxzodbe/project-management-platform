<?php

namespace Modules\Task\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Task\Emails\TaskAssignedMail;
use Modules\Task\Models\Task;

class SendTaskAssignedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Task $task,
        public User $assignee,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->assignee->email)->send(new TaskAssignedMail($this->task));

            Log::info('Email sent successfully for task assignment.', [
                'task_id' => $this->task->id,
                'assignee_id' => $this->assignee->id,
                'assignee_email' => $this->assignee->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send email for task assignment.', [
                'task_id' => $this->task->id,
                'assignee_id' => $this->assignee->id,
                'assignee_email' => $this->assignee->email,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('Job Failed: SendTaskAssignedNotification', [
            'task_id' => $this->task->id,
            'assignee_id' => $this->assignee->id,
            'reason' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
