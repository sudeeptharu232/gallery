<?php

namespace  Sudeep\Gallery\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Img;
use PrabidheeInnovations\Gallery\Http\Requests\GalleryStoreRequest;
use PrabidheeInnovations\Gallery\Http\Requests\GalleryUpdateRequest;
use PrabidheeInnovations\Gallery\Models\Gallery;
use PrabidheeInnovations\Gallery\Models\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return view('gallery::galleries', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('gallery::gallery_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryStoreRequest $request)
    {
        $gallery = Gallery::create([
            'is_published' => $request->is_published,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('/dashboard/galleries');
    }

    /**
     * Display the specified resource.
     */
    public function addImages(Request $request)
    {
        $gallery_id=$request->id;
        return view('gallery::images',compact('gallery_id'));
    }
    public function storeImages(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $folder =  storage_path('/app/public/gallery');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            if (!is_dir($folder)) {
                mkdir($folder, 0775, true);
            }

            $galleryId = $request->input('gallery_id'); // Get the gallery ID from the request
//
            $image = new Image();
            $image->image_path = 'storage/gallery/' . $filename;;
            $image->gallery_id = $galleryId; // Store the gallery ID
            $image->save();

//        }
            $slider_image_success = $file->move($folder, $filename);
            // Get image dimensions
            $width = getimagesize(storage_path("app/public/gallery/" . $filename))[0];
            $height = getimagesize(storage_path("app/public/gallery/" . $filename))[1];
            if ($width > $height) {
                if ($width > 1230 && ($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'png')) {
                    $image = new Img(new Driver());
                    $image->read(storage_path("app/public/gallery/") . $filename)->scale(width: 1230)->save(storage_path("app/public/gallery/" . $filename));
                }

            } else {
                if ($height > 688 && ($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'png')) {
                    $image = new Img(new Driver());
                    $image->read(storage_path("app/public/gallery/") . $filename)->scale(height: 688)->save(storage_path("app/public/gallery/" . $filename));
                }

            }

            //image intervention
            if ($slider_image_success) {
                return response()->json([
                    "status" => "success",
                ], 200);
            }else{
                return response()->json([
                    "status" => "error"
                ], 400);
            }

        } else {
            return response()->json('error: upload file not found.', 400);
        }

    }
    public function allUploadedImages(){
        $imagePath = 'public/gallery'; // Change this to the appropriate path where your images are stored in the public storage directory.
        $files = collect(File::files(storage_path('app/public/gallery')))->sortByDesc(function ($file) {
            return $file->getCTime();
        });
//        $files = Storage::files($imagePath);

        $images = [];
        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                $images[] = basename($file);
            }
        }

        return response()->json(['uploads' => $images]);
    }
    public function mediaImageUpload(Request $request){

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $folder =  storage_path('/app/public/gallery/images');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $slider_image_success = $file->move($folder, $filename);

            //image intervention
            if ($slider_image_success) {
                return response()->json([
                    "status" => "success",
                ], 200);
            }else{
                return response()->json([
                    "status" => "error"
                ], 400);
            }

        } else {
            return response()->json('error: upload file not found.', 400);
        }

    }
    public function destroyImage($image)
    {
        if(Storage::exists("public/gallery/".$image)){
            Storage::delete("public/gallery/".$image);
        }else{
            return response("image not found");
        }
        return redirect('dashboard/gallery/add-images');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $gallery=Gallery::where('id',$request->id)->first();
        return view('gallery::gallery_edit',compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryUpdateRequest $request)
    {
        Gallery::where('id',$request->id)->update([
            'is_published'=>$request->is_published,
            'title'=>$request->title,
            'description'=>$request->description,
        ]);
        return redirect('/dashboard/galleries');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($gallery_id)
    {
        $gallery=Gallery::with('images')->where('id',$gallery_id)->first();
        if($gallery->images->isEmpty()){
            $gallery->delete();

        } else{
            foreach ($gallery->images as $image) {
                $image->delete(); // Delete image record from database
                $gallery->delete();
            }
        }
        return redirect()->back();


    }
}
