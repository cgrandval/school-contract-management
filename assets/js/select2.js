import $ from 'jquery';
import 'select2/dist/css/select2.css';
import 'select2/dist/js/select2';

function initSelect2() {
    $('select[data-use-select2="true"]').select2();
}

$(initSelect2);

export {
    initSelect2,
};
