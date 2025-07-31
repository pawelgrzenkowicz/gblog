<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony;

enum Error: string
{
    case INVALID_DATA = 'INVALID_DATA';
    case INTERNAL_ERROR = 'INTERNAL_ERROR';
    case TOO_MANY_REQUESTS = 'TOO_MANY_REQUESTS';
    case UNABLE_TO_GENERATE_UNIQUE_UUID = 'UNABLE_TO_GENERATE_UNIQUE_UUID';

    # PICTURE #
    case PICTURE_IS_NOT_READABLE = 'PICTURE_IS_NOT_READABLE';
    case WRONG_INSTANCE = 'WRONG_INSTANCE';

    # USER #
    case BAD_CREDENTIALS = 'BAD_CREDENTIALS';
    case USER_NOT_FOUND = 'USER_NOT_FOUND';
}
