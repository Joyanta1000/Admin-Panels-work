<?php

use App\Thumbnail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        $this->g();
    }

    public function g()
    {
        
        $links = Thumbnail::whereNull('resize_link')->orWhere('resize_link', '')->get();

        foreach ($links as $link) {

            $path = $link->image_link;
            $filename = basename($path);
            $extension = strrchr($filename, '.');
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
    }
}
