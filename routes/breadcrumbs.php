<?php

// DASHBOARD
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(__('constant.DASHBOARD'), url('/admin/home'));
});


//COUNTRY
Breadcrumbs::for('country_information', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.COUNTRY_INFORMATION'), url('/admin/country-information'));
});

Breadcrumbs::for('country_create', function ($trail) {
    $trail->parent('country_information');
    $trail->push('Create', url('/admin/country-information/create'));
});

Breadcrumbs::for('country_edit', function ($trail, $id) {
    $trail->parent('country_information');
    $trail->push('Edit', url('/admin/country-information/edit', $id));
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

//SUB_CONTENTS
Breadcrumbs::
for ('menu', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.MENU'), url('/admin/menu'));
}) ;
Breadcrumbs::
for ('menu_list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.MENU'), url('/admin/menu'));
	$trail->push(__('constant.HEADER'), url('/menu-list/1'));
}) ;
Breadcrumbs::
for ('sub_menu', function ($trail, $menu,$type=null) {
    if (!empty($menu) && !empty($menu->parent)) {
        $menu1 = \App\Menu::findOrFail($menu->parent);
        $trail->parent('sub_menu', $menu1);

    } else {
    $trail->parent('dashboard');
    $trail->push(__('constant.MENU'), url('/admin/menu'));
	if($type==1)
	$trail->push(__('constant.HEADER'), url('/admin/menu-list/'.$type));
	else
	$trail->push(__('constant.FOOTER'), url('/admin/menu-list/'.$type));
    }
    if(!empty($menu)){
        $trail->push($menu->title, route('get-sub-menu', $menu->id));

    }

}) ;

Breadcrumbs::
for ('menu_create', function ($trail,$menu,$type=null) {
    $trail->parent('sub_menu', $menu,$type);
    $trail->push(__('constant.CREATE'), url('/admin/menu/create'));
}) ;


Breadcrumbs::
for ('menu_edit', function ($trail, $id,$menu,$type=null) {
    $trail->parent('sub_menu', $menu,$type);
    $trail->push(__('constant.EDIT'), url('/admin/menu/edit' . $id));
}) ;

Breadcrumbs::
for ('sub_menu_edit', function ($trail, $menu) {
    if (!empty($menu) && !empty($menu->parent)) {
        $trail->parent('sub_menu', $menu->parent);
        $trail->push($menu->title, route('get-sub-menu', $menu->id));
    } else {
        $trail->parent('menu_edit');
    }
}) ;

Breadcrumbs::for('system-setting-create', function ($trail) {
    //$trail->parent('system_setting');
    $trail->parent('dashboard');
    $trail->push(__('constant.SYSTEM_SETTING'));
    $trail->push(__('constant.CREATE'), url('/admin/system-setting/create'));
});
Breadcrumbs::for('system-setting-edit', function ($trail, $id) {
    //$trail->parent('system-setting');
    $trail->parent('dashboard');
    $trail->push(__('constant.SYSTEM_SETTING'));
    $trail->push(__('constant.EDIT'), url('/admin/system-setting/edit'. $id));
});

Breadcrumbs::for('roles-and-permission', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Roles and Permission', url('/admin/roles-and-permission'));
});

Breadcrumbs::for('create-roles-and-permission', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Roles and Permission', url('/admin/roles-and-permission/create'));
});

Breadcrumbs::for('edit-roles-and-permission', function ($trail, $id) {
	$trail->parent('roles-and-permission');
    $trail->push('Edit', url('/admin/edit-roles-and-permission/' . $id));
});

Breadcrumbs::for('create_role', function ($trail) {
    $trail->parent('roles-and-permission');
    $trail->push('Create Role', url('/admin/roles/create'));
});

Breadcrumbs::for('edit_role', function ($trail, $id) {
    $trail->parent('roles-and-permission');
    $trail->push('Edit Role', url('/admin/roles/edit/'.$id));
});

//Email templates
Breadcrumbs::for('email_template', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.EMAIL_TEMPLATE'), url('/admin/email-template'));
});

Breadcrumbs::for('email_template_create', function ($trail) {
    $trail->parent('email_template');
    $trail->push(__('constant.CREATE'), url('/admin/email-template/create'));
});
Breadcrumbs::for('email_template_edit', function ($trail, $id) {
    $trail->parent('email_template');
    $trail->push(__('constant.EDIT'), url('/admin/email-template/edit'. $id));
});

//Payment
Breadcrumbs::for('payment', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('constant.PAYMENT'), url('/admin/payment'));
});

Breadcrumbs::for('payment_create', function ($trail) {
    $trail->parent('payment');
    $trail->push(__('constant.CREATE'), url('/admin/payment/create'));
});
Breadcrumbs::for('payment_edit', function ($trail, $id) {
    $trail->parent('payment');
    $trail->push(__('constant.EDIT'), url('/admin/payment/edit'. $id));
});
