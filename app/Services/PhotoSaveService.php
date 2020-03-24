<?php


namespace App\Services;


use App\Photo;
use Illuminate\Http\UploadedFile;

class PhotoSaveService
{
    /** @var Photo */
    private $photo;

    private $error = '';

    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    public function save(UploadedFile $file): bool
    {
        $url = $file->store('public');
        if ($url) {
            try {
                $data = ['url' => $url];
                if ($this->photo->exists)
                    $this->photo->update($data);
                else
                    $this->photo = Photo::create($data);
                return true;
            } catch (\Exception $exception) {
                $this->error = $exception->getMessage();
            }
        } else
            $this->error = $file->getError();
        return false;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
