<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/16/2017
 * Time: 6:33 PM
 */

namespace App\Http\Controllers\Classes;


class FeedbackClass
{
    const TABLE_NAME = 'feedback';
    const ID = 'feedback_id';
    const EMRI = 'emri';
    const EMAIL = 'email';
    const DESC = 'desc';
    const STATUS = 'status';

    const PENDING = 1;
    const DELETED = 0;
}