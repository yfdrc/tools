Route::group(['prefix' => 'Ajax', 'namespace' => 'Ajax'], function(){
    Route::post('Cat', 'AjaxController@cat');
});
