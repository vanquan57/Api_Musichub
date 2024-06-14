<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('image')){
            try {
                $file = $request->file('image');
                $fileName = $file->getClientOriginalName();
                $imagePath = $file->storeAs('uploads', $fileName, 'public');
                return response()->json([
                    'imagePath' => $imagePath,
                  ]);
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }else if($request->hasFile('song')){
            try {
                $file = $request->file('song');
                $fileName = $file->getClientOriginalName();
                $songPath = $file->storeAs('uploads/songs', $fileName, 'public');
                return response()->json([
                    'songPath' => $songPath,
                  ]);
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }else if ($request->hasFile('musicVideo')) {
            try {
                $file = $request->file('musicVideo');
                $fileName = $file->getClientOriginalName();
                $mvPath = $file->storeAs('uploads/musicVideos', $fileName, 'public');
                return response()->json([
                    'mvPath' => $mvPath,
                  ]);
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }
    }

}
