<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class FollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
public function __construct(public User $follower) 
{
    //
}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */


public function via(object $notifiable): array
{
    $via = ['database'];

    if ($notifiable->sms_notify) {
        $via[] = 'vonage';
    }

    if ($notifiable->email_notify) {
        $via[] = 'mail';
    }

    if ($notifiable->broadcast_notify) {
        $via[] = 'broadcast';
    }

    return $via;
    }

      public function toMail(object $notifiable): MailMessage
    {
        // return (new GreetingMessage($notifiable->name))
        //     ->to($notifiable->email);

        return (new MailMessage)
            ->subject('New Follower')
            ->from('follow@write.ai', 'Write.ai')
            ->level('info')
            // ->view('mails.follow', [
            //     'user' => $notifiable,
            //     'follower' => $this->follower,
            // ])
            ->greeting("Hi {$notifiable->name},")
            ->line("{$this->follower->name} started following you.")
->action('View Profile', route('users.profile', $this->follower->username))

->line('Thank you for using our application!')
            ->salutation('Best regards,')
        ;
    }



    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New follower',
            'body' => "{$this->follower->name} started following you.", // سيجلب اسم الفلور الصحيح الآن
            'link' => route('users.profile', $this->follower->id),
            'meta' => [
                'follower_id' => $this->follower->id,
                'follower_avatar' => $this->follower->avatar,
            ],
        ];
    }

    public function toArray(object $notifiable): array
    {
        // return $this->toDatabase($notifiable);
        return [];


    }
}
