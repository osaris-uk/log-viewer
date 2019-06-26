<?php

Route::name(config('log-viewer.routes.name') . '.')->prefix(config('log-viewer.routes.prefix'))->middleware(config('log-viewer.routes.middleware'))->group(function () {
    Route::get('/{file?}', '\OsarisUk\LogViewer\Controllers\LogViewerController@index')->name('index');
});