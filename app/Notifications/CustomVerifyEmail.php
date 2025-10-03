<?Php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Custom Email Verification')
                    ->line('Please click the button below to verify your email address.')
                    ->action('Verify Email', url(route('verification.verify', ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())], false)))
                    ->line('If you did not create an account, no further action is required.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
