<?php

namespace App\Notifications;

use App\Models\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GroupCreateNotification extends Notification
{
    use Queueable;

    protected $group;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Group $group)
    {
            $this->group = $group;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("New Group #{$this->group->name}")
                    // ->from('notification@ajyal.ps', 'AJYAL ')
                    ->greeting("Hello {$notifiable->full_name},")
                    ->line("A new group (#{$this->group->name}) created by ajyal ")
                    ->action('View Gruop', url('/'))
                    ->line('Thank you ');


    }

    public function toDatabase($notifiable)
    {

        return [
            'body' => "A new group (#{$this->group->name}) created by ajyal ",
            'icon' => "{{asset('assets/images/ajyal.jpeg')}}",
            'url' => url('/'),
            'group_id' => $this->group->id,
        ];
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
            //
        ];
    }
}
