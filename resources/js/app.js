import './bootstrap';
import $ from 'jquery';
import 'select2';

$('.tech-stack-select').select2({
    tags: true,
    tokenSeparators: [',', ' ']
});
