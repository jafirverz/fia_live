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
