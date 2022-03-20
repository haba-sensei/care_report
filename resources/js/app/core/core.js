import "animate.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "./vendor.min.js";
import "./apexcharts.min.js";
import "./app-menu.js";
import "./chat.js";



import {
    library,
    dom
} from "@fortawesome/fontawesome-svg-core";
import {
    faCheck
} from "@fortawesome/free-solid-svg-icons/faCheck";
import {
    faSearch
} from "@fortawesome/free-solid-svg-icons/faSearch";
import {
    faComments
} from "@fortawesome/free-solid-svg-icons/faComments";
import {
    faPlus
} from "@fortawesome/free-solid-svg-icons/faPlus";
import {
    faEdit
} from "@fortawesome/free-solid-svg-icons/faEdit";
import {
    faTrash
} from "@fortawesome/free-solid-svg-icons/faTrash";

library.add(faCheck, faSearch, faComments, faPlus, faEdit, faTrash);
dom.watch();


// $(".scrollable-container").each(function () {
//     var scrollable_container = new PerfectScrollbar($(this)[0], {
//         wheelPropagation: false,
//     });
// });

// if ($(".search-list-main").length) {
//     var searchListMain = new PerfectScrollbar(".search-list-main", {
//         wheelPropagation: false,
//     });
// }
// if ($(".search-list-bookmark").length) {
//     var searchListBookmark = new PerfectScrollbar(".search-list-bookmark", {
//         wheelPropagation: false,
//     });
// }
// // update Perfect Scrollbar on hover
// $(".search-list-main").mouseenter(function () {
//     searchListMain.update();
// });
