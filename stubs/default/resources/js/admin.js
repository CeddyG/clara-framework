import './bootstrap';

import select2 from 'select2';
select2();

import jquery from 'jquery';
window.jQuery = jquery;
window.$ = jquery;

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

import 'admin-lte';

document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2();
}, false);

import DataTable from "datatables.net-bs4";
DataTable(window, window.$);