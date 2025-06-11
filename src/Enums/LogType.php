<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum LogType: string
{
    case SEND_REQUEST = 'send_request';
    case SUCCESS_RESULT = 'success_result';
    case FAIL_RESULT = 'fail_result';
    case PARSE_RESULT_ERROR = 'parse_result_error';
}