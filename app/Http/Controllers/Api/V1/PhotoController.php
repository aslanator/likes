<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Photo;
use App\Services\PhotoSaveService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    const ALLOWED_EXT = ['jpg', 'webp', 'png'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::withCount('likes')->with('likedByCurrentUser')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Photo::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        return $this->save($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Photo $photo */
        $photo = Photo::findOrFail($id);
        $url = $photo->url;
        $success = $photo->delete();
        if($success)
            Storage::delete($url);
        return $success;
    }

    private function checkPhotoRequest(Request $request)
    {
        if ($request->hasFile('photo')
            && $request->file('photo')->isValid()) {
            $extension = $request->photo->extension();
            return in_array($extension, self::ALLOWED_EXT);
        }
        return false;
    }

    /**
     * @param Request $request
     * @return UploadedFile | false
     */
    private function getUploadedFile(Request $request)
    {
        if ($this->checkPhotoRequest($request))
            return $request->photo;
        return false;
    }

    private function save(Request $request, ?int $id = null)
    {
        if ($file = $this->getUploadedFile($request)) {
            $photo            = $id ? Photo::findOrFail($id) : new Photo();
            $photoSaveService = new PhotoSaveService($photo);
            if ($photoSaveService->save($file))
                return $photoSaveService->getPhoto();
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $photoSaveService->getError());
        }
        abort(Response::HTTP_BAD_REQUEST, 'Photo not uploaded');
    }
}
