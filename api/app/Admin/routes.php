<?php

Route::get('', ['as' => 'admin.products', function () {
	$content = 'Define your dashboard here.';
	return AdminSection::view($content, 'Проудкты');
}]);

Route::get('information', ['as' => 'admin.information', function () {
	$content = 'Define your information here.';
	return AdminSection::view($content, 'Information');
}]);
