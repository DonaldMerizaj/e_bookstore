<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/16/2017
 * Time: 4:15 PM
 */

namespace App\Http\Controllers\Classes;


class BasketClass
{
    const TABLE_NAME = 'card';
    const ID = 'card_id';
    const ID_KLIENT = 'id_klient';
    const ID_LIBRI = 'id_libri';
    const STATUS = 'status';//nese eshte libri akoma ne card ose jo

    const ACTIVE = 1;
    const DROPPED = 0;
}