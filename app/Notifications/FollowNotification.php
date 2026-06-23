<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected  User $user,protected  User $follower)
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

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.follow-notification');
    }
public function toDatabase(object $notifiable):array{

return [

'title' =>'New follower',
'body' =>'{$this->follower->name} started following you .',
'link'=>route('users.profile',$this->follower->username),
'meta' =>[
    'follower_id'=>$this->follower->id ,
    'follower_avster'=>$this->follower->avatar,

    
    ]
];
}
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
