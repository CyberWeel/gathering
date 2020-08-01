'use strict';

import {SERVICE} from './core/constants';
import {$el, $value} from './core/functions';

const COOKIE = $el('.cookie');
const COOKIE_CLOSE = $el('.cookie .close');

if (COOKIE_CLOSE !== null) {
    COOKIE_CLOSE.addEventListener('click', e => {
        COOKIE.classList.add('hide');
        setTimeout(e => COOKIE.remove(), 200);
        document.cookie = 'agreedWithCookie=yes; path=/; max-age=' + (60 * 60 * 24 * 30);
    });
}
