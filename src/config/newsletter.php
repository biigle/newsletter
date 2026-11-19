<?php

return [

    /*
    | Maximum number of newsletter emails that are sent per hour. This must stay below
    | the hourly limit of the email provider. Emails that exceed the limit are sent in
    | the next hour(s).
    */
    'email_rate_limit' => (int) env('NEWSLETTER_EMAIL_RATE_LIMIT', 400),

];
