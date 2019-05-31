<?php

// DASHBOARD
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', url('/admin/home'));
});
