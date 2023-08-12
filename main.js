window.addEventListener('DOMContentLoaded', function() {
    let courseElem = document.getElementById('course');
    let courseNumberElem = document.getElementById('course_number');
    let sortByElem = document.getElementById('sort_by');
    let submitBtnElem = document.getElementById('submit_btn');
    courseElem.onclick = function() {
        gtag('event', 'clicked_course');
    }

    courseNumberElem.onclick = function() {
        gtag('event', 'clicked_course_number');
    }

    sortByElem.onclick = function() {
        gtag('event', 'clicked_sort_by');
    }

    submitBtnElem.onclick = function() {
        gtag('event', 'clicked_submit_btn', {
            course: courseElem.value,
            course_number: courseNumberElem.value,
            sort_by: sortByElem.value,
        });
    }
})