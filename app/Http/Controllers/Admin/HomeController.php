<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Thumbnail;
use Image;

use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    public function hotelLink()
    {

        $links = Thumbnail::all();

        return view('admin.hotel-link', compact('links'));
    }

    public function resizeAndDownload()
    {

        // ini_get('allow_url_fopen') ? 'Enabled' : 'Disabled';
        // ini_get('allow_url_fopen') ? 'Enabled' : 'Disabled';
        // get data where resize link is empty or null
        $links = Thumbnail::whereNull('resize_link')->orWhere('resize_link', '')->get();

        // $image->resize(200, 200, function($constraint){
        //     $constraint->aspectRatio();
        // });
        // dd($links);

        foreach ($links as $link) {

            $path = $link->image_link;
            // if i get any encoded data in url, decode it
            // dd(urldecode(basename($path)));
            // $path2 = 'http://www.chutyrooms.com/images/'.urlencode(basename($path));
            //$extension = strrchr( $path, '/');
            // dd($path2);

            // get client original name

            $filename = basename($path);
            // dd($filename);

            // get extension
            $extension = strrchr($filename, '.');
            // dd($extension);

            // get filename without extension
            $name = str_replace($extension, '', $filename);
            $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);


            $random = Str::random(10);
            $date = date('d-m-Y-H-i-s');


            $filename = 'thumbnail-images/' . $name . $random . $date . '.' . 'jpg';

            $path_to = file_get_contents($path, false, stream_context_create([
                'ssl' => [
                    'verify_peer'      => false,
                    'verify_peer_name' => false,
                ],
            ]));

            Image::make($path_to)->resize(200, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($filename));

            $link->resize_link = $filename;


            $link->save();
        }
        return redirect()->back();
    }
}
