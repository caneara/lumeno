<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resource Limits
    |--------------------------------------------------------------------------
    |
    | This section controls the maximum number of a given resource that a user
    | may create or maintain at any given time. The purpose of these limits
    | is primarily to prevent people from trying to game the system.
    |
    */

    'limits' => [
        'skills'       => 25,
        'schools'      => 10,
        'projects'     => 10,
        'workplaces'   => 20,
        'requirements' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Invitation Batch Size
    |--------------------------------------------------------------------------
    |
    | This value controls the maximum number of vacancy invitations that will
    | be sent within a given batch. In essence, this serves as a throttle to
    | prevent Lumeno hitting the AWS SES rate-per-second limit.
    |
    */

    'invitation_batch_size' => env('INVITATION_BATCH_SIZE', 50),

    /*
    |--------------------------------------------------------------------------
    | Invitation Batch Delay
    |--------------------------------------------------------------------------
    |
    | This value controls the maximum number of seconds that the batch process
    | should pause between sessions. The limit exists to prevent any excess
    | write requests to the database (gives it time to breathe).
    |
    */

    'invitation_batch_delay' => env('INVITATION_BATCH_DELAY', 1),

    /*
    |--------------------------------------------------------------------------
    | Invitation Batch Duration
    |--------------------------------------------------------------------------
    |
    | This value controls the maximum number of seconds that the batch process
    | may continue to run for. The limit exists to prevent any overlapping of
    | batch processing, thereby avoiding any AWS SES rate-per-second errors.
    |
    */

    'invitation_batch_duration' => env('INVITATION_BATCH_DURATION', 40),

];
