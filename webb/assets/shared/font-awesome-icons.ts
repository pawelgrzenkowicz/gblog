import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from '@fortawesome/fontawesome-svg-core'

import {
    faFacebookF as fabFacebook,
    faInstagram as fabInstagram,
    faTiktok as fabTikTok,
    faYoutube as fabYoutube,
} from '@fortawesome/free-brands-svg-icons'

import {
    faBars as fasBars,
    faBook as fasBook,
    faEye as fasEye,
    faHouse as fasHouse,
    faPen as fasPen,
    faScroll as fasScroll,
    faTrashCan as fasTrashCan,
    faUser as fasUser,
    faXmark as fasXmark
} from '@fortawesome/free-solid-svg-icons';

library.add(fabFacebook, fabInstagram, fabTikTok, fabYoutube);
library.add(fasBars, fasBook, fasEye, fasHouse, fasPen, fasScroll, fasTrashCan, fasUser, fasXmark);

export default FontAwesomeIcon;
