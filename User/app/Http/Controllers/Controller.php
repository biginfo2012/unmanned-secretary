<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS = 'success';
    const ERROR = 'error';
    const ERR_INVALID_UNKNOWN = 'ERR_INVALID_UNKNOWN';
    const ERR_INVALID_USER_EMAIL = 'ERR_INVALID_USER_EMAIL';
    const ERR_INVALID_USER_STATUS = 'ERR_INVALID_USER_STATUS';
    const ERR_INVALID_PASSWORD = 'ERR_INVALID_PASSWORD';
    const ERR_INVALID_USER = 'ERR_INVALID_USER';
    const ERR_INVALID_IMAGE = 'ERR_INVALID_IMAGE';
    const ERR_INVALID_SHOP_NAME = 'ERR_INVALID_SHOP_NAME';
    const ERR_INVALID_PAY_DATE = 'ERR_INVALID_PAY_DATE';
    const ERR_INVALID_TOTAL = 'ERR_INVALID_TOTAL';
    const ERR_INVALID_PERCENT = 'ERR_INVALID_PERCENT';
}
