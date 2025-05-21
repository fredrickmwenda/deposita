<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewClientUserRegistered extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->subject('New Client User Registration')
    //         ->greeting('Hello ' . $notifiable->name . ',')
    //         ->line('A new client user has registered and is awaiting activation:')
    //         ->line('Name: ' . $this->user->name)
    //         ->line('Email: ' . $this->user->email)
    //         ->action('Activate User', url(route('users.index')))
    //         ->line('You can activate this user from your dashboard.');
    // }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'message' => 'A new client user has registered and is awaiting activation.'
        ];
    }
}
