window.addEventListener('DOMContentLoaded', function () {
    setupGtag();
    addSearchParams()
})

function addSearchParams() {
    const searchParams = new URLSearchParams(window.location.search);

    const courseInput = document.getElementById("course");
    const courseNumberInput = document.getElementById("course_number");
    const sortByInput = document.getElementById("sort_by");
    const submitBtn = document.getElementById("submit_btn");

    courseInput.value = searchParams.get("course");
    courseNumberInput.value = searchParams.get("number");
    if(searchParams.get("sort_by")){
        sortByInput.value = searchParams.get("sort_by")
    }

    if (searchParams.get("course") && searchParams.get("number")) {
        submitBtn.click();
    }}

function setupGtag() {
    let courseElem = document.getElementById('course');
    let courseNumberElem = document.getElementById('course_number');
    let sortByElem = document.getElementById('sort_by');
    let submitBtnElem = document.getElementById('submit_btn');
    courseElem.onclick = function () {
        gtag('event', 'clicked_course');
    }

    courseNumberElem.onclick = function () {
        gtag('event', 'clicked_course_number');
    }

    sortByElem.onclick = function () {
        gtag('event', 'clicked_sort_by');
    }

    submitBtnElem.onclick = function () {
        gtag('event', 'clicked_submit_btn', {
            course: courseElem.value,
            course_number: courseNumberElem.value,
            sort_by: sortByElem.value,
        });
    }
}