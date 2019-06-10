<?php

// DASHBOARD
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', url('/admin/home'));
});

Breadcrumbs::for ('filter', function ($trail) {
		$trail->parent('dashboard');
		$trail->push(__('constant.FILTER'), url('/admin/filter'));
	}) ;
	
Breadcrumbs::for ('filter_create', function ($trail) {
	$trail->parent('filter');
	$trail->push(__('constant.CREATE'), url('/admin/filter/create'));
}) ;

Breadcrumbs::for ('filter_edit', function ($trail, $id) {
	$trail->parent('filter');
	$trail->push(__('constant.EDIT'), url('/admin/filter/edit' . $id));
}) ;
//BANNER
Breadcrumbs::
for ('banner', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.BANNER'), url('/admin/banner'));
}) ;

Breadcrumbs::
for ('banner_create', function ($trail) {
    $trail->parent('banner');
    $trail->push(__('constant.CREATE'), url('/admin/banner/create'));
}) ;

Breadcrumbs::
for ('banner_edit', function ($trail, $id) {
    $trail->parent('banner');
    $trail->push(__('constant.EDIT'), url('/admin/banner/edit' . $id));
}) ;


//CONTENTS
Breadcrumbs::
for ('page', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.PAGE'), url('/admin/page'));
}) ;

Breadcrumbs::
for ('page_create', function ($trail) {
    $trail->parent('page');
    $trail->push(__('constant.CREATE'), url('/admin/page/create'));
}) ;

Breadcrumbs::
for ('page_edit', function ($trail, $id) {
    $trail->parent('page');
    $trail->push(__('constant.EDIT'), url('/admin/page/edit' . $id));
}) ;