<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostRejected extends Notification
{
    use Queueable;

    /**
     * Rejected post.
     *
     * @var \App\Models\Post
     */
    private $post;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Post $post
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
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
        return "Your post with title '{$this->post->title}' has been rejected due to use of bad words.";
    }
}
