<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropositionNotification extends Notification //implements ShouldBroadcast
{
    use Queueable;
    protected $proposition;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($proposition)
    {
        $this->proposition = $proposition;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'proposition',
            'proposition' => $this->proposition,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'proposition',
            'proposition' => $this->proposition,
        ];
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    /*public function broadcastOn()
    {
        //return new PrivateChannel('channel-proposition');
        return ['channel-proposition'];
    }

    public function broadcastAs()
    {
        //return new PrivateChannel('channel-proposition');
        return 'event-proposition';
    }*/
}
