import $ from 'jquery';
import { initSelect2 } from './select2';

function createCourseForm() {
    if (!$('#course-prototype').data('nextIndex')) {
        $('#course-prototype').data('nextIndex', 1);
    }

    const nextIndex = $('#course-prototype').data('nextIndex');

    $('#course-prototype').data('nextIndex', nextIndex + 1);

    return $('#course-prototype')
        .data('prototype')
        .replace(/__name__/g, `new_${nextIndex}`)
    ;
}

function appendNewCourseForm() {
    const nextIndex = document.querySelectorAll('.contract-courses > *').length;
    const $newCourse = $(createCourseForm());

    listenRemoveButton($newCourse);
    prefillFromFirstCourse($newCourse);

    $('.new-course').before($newCourse);

    initSelect2();
}

function prefillFromFirstCourse($courseItem) {
    const $container = $('.contract-courses');

    if ($container.children().length < 2) {
        return;
    }

    const $firstCourse = $container.find('> :first-child');

    ['courseLabel', 'session', 'intervener'].forEach(field => {
        let firstValue;
        if (firstValue = $firstCourse.find(`select[name*="${field}"]`).val()) {
            $courseItem.find(`select[name*="${field}"]`).val(firstValue);
        }
    });

}

function listenRemoveButton($courseItem) {
    $courseItem.find('.remove-course').click(event => {
        event.preventDefault();
        $courseItem.remove();
    });
}

function addNewLineIfEmpty() {
    if ($('.contract-courses > *').length < 2) {
        appendNewCourseForm();
    }
}

$(() => {
    const addCourseButton = document.querySelector('.add-new-course');

    if (!addCourseButton) {
        return;
    }

    addCourseButton.addEventListener('click', event => {
        event.preventDefault();
        appendNewCourseForm();
    });

    $('.contract-courses > *').each((index, courseItem) => {
        listenRemoveButton($(courseItem));
    });

    addNewLineIfEmpty();
});
