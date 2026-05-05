<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
LicenSys
├─ .editorconfig
├─ app
│  ├─ Actions
│  │  └─ Fortify
│  │     ├─ CreateNewUser.php
│  │     ├─ PasswordValidationRules.php
│  │     ├─ ResetUserPassword.php
│  │     ├─ UpdateUserPassword.php
│  │     └─ UpdateUserProfileInformation.php
│  ├─ Classes
│  │  ├─ Abstract
│  │  │  └─ CRUD.php
│  │  ├─ BusinessRule
│  │  ├─ CompanyClass.php
│  │  ├─ HistoricCompanyClass.php
│  │  ├─ PaymentClass.php
│  │  ├─ PaymentMethodClass.php
│  │  └─ SystemClass.php
│  ├─ Console
│  │  └─ Commands
│  │     ├─ MonthlyStatusServiceCommand.php
│  │     └─ MonthsNewYearCommand.php
│  ├─ Enum
│  │  ├─ MonthlyFee.php
│  │  ├─ ToastType.php
│  │  └─ TypeUser.php
│  ├─ Facades
│  │  ├─ SystemClassFacade.php
│  │  └─ Toast.php
│  ├─ global_constants.php
│  ├─ helpers.php
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ API
│  │  │  │  ├─ ConectorController.php
│  │  │  │  ├─ LicenseManagerController.php
│  │  │  │  └─ TransferController.php
│  │  │  ├─ CompanyController.php
│  │  │  ├─ CompanyGroupController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ DashboardController.php
│  │  │  ├─ HistoricCompanyController.php
│  │  │  ├─ HistoricPaymentMethodsController.php
│  │  │  ├─ PaymentController.php
│  │  │  ├─ PaymentMethodController.php
│  │  │  ├─ SystemController.php
│  │  │  └─ UserController.php
│  │  └─ Middleware
│  │     ├─ Admin.php
│  │     ├─ HandleInertiaRequests.php
│  │     └─ VerfiyEmailAdmin.php
│  ├─ Models
│  │  ├─ Company.php
│  │  ├─ GroupCompany.php
│  │  ├─ HistoricCompany.php
│  │  ├─ HistoricPaymentMethod.php
│  │  ├─ Payment.php
│  │  ├─ PaymentMethod.php
│  │  ├─ Pivot
│  │  ├─ System.php
│  │  └─ User.php
│  ├─ Providers
│  │  ├─ AppServiceProvider.php
│  │  └─ FortifyServiceProvider.php
│  ├─ Services
│  │  ├─ API
│  │  │  ├─ CompanyService.php
│  │  │  ├─ ConectorService.php
│  │  │  ├─ LicenseManagerService.php
│  │  │  ├─ TokensManagerService.php
│  │  │  └─ TransferService.php
│  │  ├─ CompanyGroupService.php
│  │  ├─ CompanyService.php
│  │  ├─ Cron
│  │  │  └─ MonthlyFeeCron.php
│  │  ├─ DashboardService.php
│  │  ├─ HistoricCompanyService.php
│  │  ├─ HistoricPaymentMethodsService.php
│  │  ├─ PaymentMethodService.php
│  │  ├─ PaymentService.php
│  │  ├─ SystemService.php
│  │  └─ UserService.php
│  ├─ Traits
│  │  └─ EnumFunctions.php
│  └─ Utils
│     └─ ToastFacade.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ pac612A.tmp
│  │  ├─ packages.php
│  │  ├─ ser61E6.tmp
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ fortify.php
│  ├─ inertia.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ sanctum.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2025_02_27_210159_create_systems_table.php
│  │  ├─ 2025_02_27_210403_create_group_companies_table.php
│  │  ├─ 2025_02_27_210547_create_companies_table.php
│  │  ├─ 2025_02_27_210548_create_historic_companies_table.php
│  │  ├─ 2025_03_06_144728_add_two_factor_columns_to_users_table.php
│  │  ├─ 2025_12_06_125652_create_personal_access_tokens_table.php
│  │  ├─ 2026_02_14_112904_create_payments_table.php
│  │  ├─ 2026_02_14_113217_create_payment_methods_table.php
│  │  └─ 2026_02_14_113401_create_historic_payment_methods_table.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     └─ UsersTableSeeder.php
├─ lang
│  ├─ en
│  │  ├─ auth.php
│  │  ├─ pagination.php
│  │  ├─ passwords.php
│  │  └─ validation.php
│  ├─ pt-BR
│  │  ├─ auth.php
│  │  ├─ pagination.php
│  │  ├─ passwords.php
│  │  └─ validation.php
│  └─ pt-BR.json
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ public
│  ├─ .htaccess
│  ├─ assets
│  │  ├─ favicon.png
│  │  └─ quadro_logo.png
│  ├─ favicon.ico
│  ├─ img
│  │  └─ load.gif
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  ├─ components
│  │  │  ├─ Button.vue
│  │  │  ├─ Card.vue
│  │  │  ├─ Input.vue
│  │  │  ├─ Modal.vue
│  │  │  ├─ Paginate.vue
│  │  │  └─ SideBar.vue
│  │  ├─ layouts
│  │  │  ├─ AuthLayout.vue
│  │  │  └─ SidebarLayout.vue
│  │  ├─ Pages
│  │  │  ├─ Auth
│  │  │  │  ├─ 2FAChallenge.vue
│  │  │  │  ├─ ConfirmPassword.vue
│  │  │  │  ├─ ForgotPassword.vue
│  │  │  │  ├─ Login.vue
│  │  │  │  ├─ ProfileEdit.vue
│  │  │  │  ├─ ResetPassword.vue
│  │  │  │  └─ VerifyEmail.vue
│  │  │  ├─ Company
│  │  │  │  ├─ Create.vue
│  │  │  │  ├─ Index.vue
│  │  │  │  └─ Update.vue
│  │  │  ├─ CompanyGroup
│  │  │  │  └─ Index.vue
│  │  │  ├─ ErrorPage.vue
│  │  │  ├─ HistoricCompany
│  │  │  │  └─ Index.vue
│  │  │  ├─ Index.vue
│  │  │  ├─ Payment
│  │  │  │  └─ Index.vue
│  │  │  ├─ PaymentMethod
│  │  │  │  └─ Index.vue
│  │  │  ├─ System.vue
│  │  │  └─ User
│  │  │     ├─ Index.vue
│  │  │     └─ Save.vue
│  │  ├─ PartialPages
│  │  │  ├─ PaymentMethod.vue
│  │  │  └─ PaymentMethodList.vue
│  │  └─ utils
│  │     ├─ date.js
│  │     ├─ enum.js
│  │     └─ functions.js
│  └─ views
│     └─ app.blade.php
├─ routes
│  ├─ api.php
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  │  └─ statement
│  │  │     └─ eYzklUewarcV2OaJWiLIAwz3gfctgHXQeXEaEsht.pdf
│  │  └─ public
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 39e1cf5d8a7d9bac753d33eafffe3b99.php
│  │     ├─ 558eac8090b750917e0401a38c4ddfab.php
│  │     ├─ 58f6b5ecbad88fc4da15879dbc7f6e69.blade.php
│  │     ├─ 6b4be6f7a61700d2f0d04931841f26e5.php
│  │     ├─ 8cb0c7876f39a3bee183f637b0b306a9.php
│  │     ├─ a811b7b72434847439fa0557af73cc05.php
│  │     └─ dca1a29b69452d307c2c30a7b9cc0a6e.blade.php
│  └─ logs
│     └─ laravel.log
├─ tests
│  ├─ Feature
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```