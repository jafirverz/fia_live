<?php

// DASHBOARD
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(__('constant.DASHBOARD'), url('/admin/home'));
});


//COUNTRY
Breadcrumbs::for('country', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.COUNTRY'), url('/admin/country'));
});

Breadcrumbs::for('country_create', function ($trail) {
    $trail->parent('country');
    $trail->push('Create', url('/admin/country/create'));
});

Breadcrumbs::for('country_edit', function ($trail, $id) {
    $trail->parent('country');
    $trail->push('Edit', url('/admin/country/edit', $id));
});

//REGULATORY
Breadcrumbs::for('regulatory', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.REGULATORY'), url('/admin/regulatory'));
});

Breadcrumbs::for('regulatory_create', function ($trail) {
    $trail->parent('regulatory');
    $trail->push('Create', url('/admin/regulatory/create'));
});

Breadcrumbs::for('regulatory_edit', function ($trail, $id) {
    $trail->parent('regulatory');
    $trail->push('Edit', url('/admin/regulatory/edit', $id));
});

//TOPIC
Breadcrumbs::for('topic', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.TOPIC'), url('/admin/topic'));
});

Breadcrumbs::for('topic_create', function ($trail) {
    $trail->parent('topic');
    $trail->push('Create', url('/admin/topic/create'));
});

Breadcrumbs::for('topic_edit', function ($trail, $id) {
    $trail->parent('topic');
    $trail->push('Edit', url('/admin/topic/edit', $id));
});

//CONTACT ENQUIRY
Breadcrumbs::for('contactenquiry', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.CONTACTENQUIRY'), url('/admin/contact-enquiry'));
});

//GROUP MANAGEMENT
Breadcrumbs::for('groupmanagement', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.GROUPMANAGEMENT'), url('/admin/group-management'));
});

Breadcrumbs::for('groupmanagement_create', function ($trail) {
    $trail->parent('groupmanagement');
    $trail->push('Create', url('/admin/group-management/create'));
});

Breadcrumbs::for('groupmanagement_edit', function ($trail, $id) {
    $trail->parent('groupmanagement');
    $trail->push('Edit', url('/admin/group-management/edit', $id));
});
