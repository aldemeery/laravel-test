<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Str;

class CommentRejected extends Notification
{
    use Queueable;

    /**
     * Rejected comment.
     *
     * @var \App\Models\Comment
     */
    private $comment;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Comment $comment
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->getMessage(),
        ];
    }

    /**
     * Get the notification message.
     *
     * @return string
     */
    private function getMessage(): string
    {
        $content = Str::limit($this->comment->content, 10);

        return "Your comment with title '{$content}' has been rejected due to use of bad words.";
    }
}
