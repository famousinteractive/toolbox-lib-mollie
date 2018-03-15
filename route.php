<?php

Route::any('mollie/callback', [
    'as'    => 'mollie.callback',
    'uses'  => 'MollieController@callback'
]);


Route::get('mollie/after', [
    'as'    => 'mollie.after',
    'uses'  => 'MollieController@afterPayment'
]);