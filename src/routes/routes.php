<?php
use Illuminate\Support\Facades\Route;
use PrabidheeInnovations\Gallery\Http\Controllers\GalleryController;

Route::group(["prefix" => "dashboard"], function (){
    //galleries
    Route::get("galleries",[GalleryController::class,'index']);
    Route::get("gallery/new",[GalleryController::class,'create']);
    Route::post("gallery/create",[GalleryController::class,'store']);
    Route::get("gallery/edit",[GalleryController::class,'edit']);
    Route::get("gallery/add-images",[GalleryController::class,'addImages']);
    Route::post("gallery/update",[GalleryController::class,'update']);
    Route::delete("gallery/delete/{gallery_id}",[GalleryController::class,'destroy']);
    Route::post("gallery/storeImages",[GalleryController::class,'storeImages']);
    Route::get('/gallery/image', [GalleryController::class,'allUploadedImages']);
    Route::post('/gallery/uploadmedia', [GalleryController::class,'mediaImageUpload']);
    Route::get('/gallery/destroyImage/{imageDeletion}', [GalleryController::class,'destroyImage']);


});
