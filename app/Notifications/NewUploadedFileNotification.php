<?php

namespace App\Notifications;

use App\Jobs\ParseAttemptHtmlDocument;
use App\UploadedFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;
use Illuminate\Support\Facades\Storage;

class NewUploadedFileNotification extends Notification
{
    use Queueable;

    protected $uploadedFile;
    protected $parsedArgs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
        $this->parsedArgs = (new ParseAttemptHtmlDocument($uploadedFile))->handle();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        return DiscordMessage::create("", [
            'title' => $this->parsedArgs['course_slug'],
            'description' => count($this->parsedArgs['questions']) . ' questões registradas',
            'url' => Storage::cloud()->url($this->uploadedFile->filename),
        ]);
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
