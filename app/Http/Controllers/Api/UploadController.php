<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    public function upLoad(UploadRequest $request)
    {
        /*
        // if ($request->hasFile('uploadFile')) {
//        if ($request->file('upLoadFile')->isValid()) {
            $file = $request->file('uploadFile');
            // $path = $request->uploadFile->path();
            // dd($path);
            $extension = $request->uploadFile->extension();
            // $fileNameWithExtension = $file->getClientOriginalName();
            $fileNameWithExtension = $request->userId . '-' . time() . '.' . $extension;
            // $path = $request->uploadFile->store('uploads\images');
            // dd($path);
            if ($file->move(public_path('/uploads/'), $fileNameWithExtension)) {
                $fileUrl = url('/uploads/' . $fileNameWithExtension);
                return response()->json(['url' => $fileUrl], JsonResponse::HTTP_OK);
            }
            // $path = $request->uploadFile->storeAs('uploads/images', $fileNameWithExtension);
            // return response()->json(['url' => asset($path)], JsonResponse::HTTP_OK);

//        }
        // } else {
        //     return response()->json(['message' => 'Dosya yükleme alanının doldurulması zorunludur!']);
        // }
        */
            $file = $request->upLoadFile;
            $extension = $request->upLoadFile->extension();
            $fileNameWithExtension = $request->userId . '-' . time() . '.' . $extension;
            // $path = $request->uploadFile->store('uploads/images');
            $path = $request->upLoadFile->storeAs('uploads/images', $fileNameWithExtension, 'public');
            return response()->json(['File Path: ' => asset("storage/$path")], JsonResponse::HTTP_OK); // public alanına dosya yüklerken asset'i kullanırız.
            // return response()->json(['File Path: ' => Storage::url($path)], JsonResponse::HTTP_OK); // bulut sunucularda dosya yüklerken Storage::url'yi kullanırız.
    }

}
