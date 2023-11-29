<?php

declare(strict_types=1);

namespace App\Notifications\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    private string $token;
    private string $endpoint;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
        $this->endpoint = config('app.url') . '/password-reset';
    }

    /**
     * @param mixed $notifiable
     */
    protected function resetUrl($notifiable): string
    {
        return $this->endpoint . '?' . http_build_query([
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        info('URL:' . $this->resetUrl($notifiable));
        return (new MailMessage)
            ->line('アカウントのパスワードリセットリクエストを受けつけました。')
            ->action('パスワードリセット', $this->resetUrl($notifiable))
            ->line('このパスワードリセットリンクの使用期限は60分です。')
            ->line('このメールに身に覚えがない場合は無視してください。');
    }
}
