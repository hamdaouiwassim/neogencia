<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMTP (.env)
    |--------------------------------------------------------------------------
    |
    | Typical production setup:
    |
    |   MAIL_MAILER=smtp
    |   MAIL_HOST=smtp.example.com
    |   MAIL_PORT=587
    |   MAIL_USERNAME=your-username
    |   MAIL_PASSWORD=your-password
    |   MAIL_SCHEME=tls          (optional; port 465 often uses MAIL_SCHEME=smtps)
    |   MAIL_FROM_ADDRESS=noreply@example.com
    |   MAIL_FROM_NAME="${APP_NAME}"
    |   MAIL_CONTACT_TO=hello@example.com
    |
    | Or use a single DSN (overrides host/port/user/password when set):
    |
    |   MAIL_URL=smtp://user:pass@host:587
    |
    | OVHcloud (MX Plan / email included with hosting):
    |
    |   MAIL_MAILER=smtp
    |   MAIL_HOST=ssl0.ovh.net
    |   MAIL_USERNAME=your-full-address@yourdomain.com
    |   MAIL_PASSWORD=your-mailbox-password
    |   MAIL_FROM_ADDRESS must match an authorized mailbox on your domain.
    |
    |   Prefer port 465 + implicit TLS:
    |     MAIL_PORT=465
    |     MAIL_SCHEME=smtps
    |
    |   Or port 587 + STARTTLS:
    |     MAIL_PORT=587
    |     MAIL_SCHEME=tls
    |
    | Exchange / other OVH offers may use a different outgoing host; check the
    | OVH help centre for your product.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send all email
    | messages unless another mailer is explicitly specified when sending
    | the message. All additional mailers can be configured within the
    | "mailers" array. Examples of each type of mailer are provided.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers that can be used
    | when delivering an email. You may specify which one you're using for
    | your mailers below. You may also add additional mailers if needed.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
            'retry_after' => 60,
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
            'retry_after' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all emails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all emails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact form recipient
    |--------------------------------------------------------------------------
    |
    | Address that receives messages from the public contact form.
    |
    */

    'contact' => [
        'to' => env('MAIL_CONTACT_TO', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    ],

];
