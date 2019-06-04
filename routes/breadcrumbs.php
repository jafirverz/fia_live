<?php

// DASHBOARD
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', url('/admin/home'));
});


//COUNTRY
Breadcrumbs::for('country', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Country', url('/admin/country'));
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
    $trail->push('Regulatory', url('/admin/regulatory'));
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
    $trail->push('Topic', url('/admin/topic'));
});

Breadcrumbs::for('topic_create', function ($trail) {
    $trail->parent('topic');
    $trail->push('Create', url('/admin/topic/create'));
});

Breadcrumbs::for('topic_edit', function ($trail, $id) {
    $trail->parent('topic');
    $trail->push('Edit', url('/admin/topic/edit', $id));
});
