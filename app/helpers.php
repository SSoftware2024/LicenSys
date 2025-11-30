<?php

//Flash message inertia, colocar em config
const RESPONSE_DATA_KEY_INERTIA = 'response_data';


if (!function_exists('routesFortify')) {
    /**
     * Retorna um array com as rotas do fortify, para saber o tipo use 'route:list'
     * php artisan route:list | grep "Fortify"
     * @return array
     */
    function routesFortify(): array
    {
        return [
            'login_get' => route('login'), //GET
            'login_post' => route('login.store'), //POST
            'logout_post' => route('logout'), //POST

            //REGISTRO
            // 'register_post' => route('register.store'),//POST
            // 'register_get' => route('register'),//POST

            //RESET(UPDATE) PASSWORDS - LOGIN INCLUÍDO
            'reset_password_post' => route('password.update'), //POST
            'reset_password_get' => 'password.reset', //GET, precisa de parametro na hora execução
            'forgot_password_get' => route('password.request'), //GET
            'forgot_password_post' => route('password.email'), //POST

            //CONFIRM PASSWORDS
            'confirm_password_get' => route('password.confirm'), //GET (VIEW - OPCIONAL)
            'confirm_password_post' => route('password.confirm.store'), //POST
            'confirmed_password_status_get' => route('password.confirmation'), //GET (STATUS)

            //EMAIL VERIFICANTION
            'verificationSend_post' => route('verification.send'), // POST
            'verificationNotice_get' => route('verification.notice'), // GET (VIEW)
            'verificationVerify_get' => 'verification.verify', // GET, precisa de parametro na hora execução

            //UPDATE PROFILE INFORMATION
            'profile_information_put' => route('user-profile-information.update'), //PUT
            'password_user_update_put' => route('user-password.update'), //PUT

            //TWO FACTOR AUTH
            // 'two_factor_confirm_post' => route('two-factor.confirm'), //POST, confrimar senha option 'confirm', espera um 'code'
            // 'two_factor_challenge_login_get' => route('two-factor.login'), //GET
            // 'two_factor_challenge_login_post' => route('two-factor.login.store'), //POST
            // 'two_factor_authentication_enable_post' => route('two-factor.enable'), //POST
            // 'two_factor_authentication_disable_delete' => route('two-factor.disable'), // DELETE
            // 'two_factor_qr_code_get' => route('two-factor.qr-code'), //GET
            /**
             * GET e POST
             *
             * GET recupera
             * POST gera novos
             */
            // 'two_factor_recovery_codes_get_post' => route('two-factor.recovery-codes'),
            // 'two_factor_secret_key_get' => route('two-factor.secret-key'), //GET
        ];
    }
}


if (!function_exists('convertToMoney')) {

    /**
     * convertToMoney
     *
     * @param  string $money
     * @return float
     */
    function convertToMoney(string $money): float
    {
        return (float) str_replace(['.', ','], ['', '.'], $money);
    }
}
if (!function_exists('getMoneyToStringBr')) {


    /**
     * getMoneyToStringBr
     *
     * @param  float $money
     * @return string
     */
    function getMoneyToStringBr(float $money): string
    {
        return number_format($money, 2, ',', '.');
    }
}
