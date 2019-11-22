/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

// make table rows clickable at tickets.index
$(function () {

    $(".js-table").on("click", "tr[data-url]", function () {
        window.location = $(this).data("url");
    });

});

$(document).ready(function () {

    setTimeout(function () {
        $('.message').hide("slow");
    }, 3000);
});

$(document).ready(function () {
    $(document).on('submit', 'form', function () {
        $('button').attr('disabled', 'disabled');
    });
});


// Update ticket assignee
$(document).on("click", ".remove_assignee", function () {
    var edit_id = document.getElementById('remove').getAttribute("assignee-id");

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/tickets/removeAssignee',
        method: 'post',
        data: {
            id: edit_id,
            assigned_to: null
        },
        success: function (res) {
            document.getElementById('remove').remove();
            document.getElementById('assignee-name').innerHTML = '';
            removeAssigneeMessage();
        }
    });
});


function removeAssigneeMessage() {
    const div = document.createElement("div");
    div.className = "alert alert-danger message";
    div.setAttribute('role', 'alert');
    $(".header").before($(div));

    $(".message").append('<strong>Assignee removed.</strong>');

    setTimeout(function () {
        $('.message').hide("slow");
    }, 3000);
}

