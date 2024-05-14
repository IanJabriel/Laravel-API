<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //

        // VerifyEmail::toMailUsing(function($notifiable, $url){
        //     return (new MailMessage)
        //     ->subject('Verifique sua caixa de E-mail')
        //     ->line('Clique no link abaixo para verificar seu e-mail')
        //     ->action('Verifique seu e-mail', $url)
        //     ->line('Se você não criou uma conta, nenhuma ação é requirida');
        // });

        // ResetPassword::toMailUsing(function($notifiable, $url){
        //     $expires = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        //     return (new MailMessage)
        //     ->subject('Notificação de troca de senha')
        //     ->line('Se você recebeu esta e-mail é porque foi solicitado uma troca de senha para sua conta.')
        //     ->action('Trocar de senha', $url)
        //     ->line('Este link de troca de senha expirará em '.$expires. 'minutos.')
        //     ->line('Se você não solicitou a troca de senha, apenas ignores esta mensagem.');
        // });
    }
}
