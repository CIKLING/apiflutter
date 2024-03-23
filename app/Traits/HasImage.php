<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage2($request, $path)
    {
        $image = null;

        if($request){
            $image = $request;
            $image->storeAs($path, $image->hashName());
            return $image->hashName();
        }else{
            return $image = null;
        }
    }

    public function updateImage2($request, $path, $kelahiran)
    {
        if($request->file('img1')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img1));
            $this->uploadImage2($request->file('img1'), $path);
            $kelahiran->persyaratan->update([
                'img1' => $request->file('img1')->hashName(),
            ]);
        }
        if($request->file('img2')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img2));
            $this->uploadImage2($request->file('img2'), $path);
            $kelahiran->persyaratan->update([
                'img2' => $request->file('img2')->hashName(),
            ]);
        }
        if($request->file('img3')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img3));
            $this->uploadImage2($request->file('img3'), $path);
            $kelahiran->persyaratan->update([
                'img3' => $request->file('img3')->hashName(),
            ]);
        }
        if($request->file('img4')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img4));
            $this->uploadImage2($request->file('img4'), $path);
            $kelahiran->persyaratan->update([
                'img4' => $request->file('img4')->hashName(),
            ]);
        }
        if($request->file('img5')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img5));
            $this->uploadImage2($request->file('img5'), $path);
            $kelahiran->persyaratan->update([
                'img5' => $request->file('img5')->hashName(),
            ]);
        }
        if($request->file('img6')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img6));
            $this->uploadImage2($request->file('img6'), $path);
            $kelahiran->persyaratan->update([
                'img6' => $request->file('img6')->hashName(),
            ]);
        }
        if($request->file('img7')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img7));
            $this->uploadImage2($request->file('img7'), $path);
            $kelahiran->persyaratan->update([
                'img7' => $request->file('img7')->hashName(),
            ]);
        }
        if($request->file('img8')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img8));
            $this->uploadImage2($request->file('img8'), $path);
            $kelahiran->persyaratan->update([
                'img8' => $request->file('img8')->hashName(),
            ]);
        }
        if($request->file('img9')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img9));
            $this->uploadImage2($request->file('img9'), $path);
            $kelahiran->persyaratan->update([
                'img9' => $request->file('img9')->hashName(),
            ]);
        }
        if($request->file('img10')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img10));
            $this->uploadImage2($request->file('img10'), $path);
            $kelahiran->persyaratan->update([
                'img10' => $request->file('img10')->hashName(),
            ]);
        }
        if($request->file('img11')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img11));
            $this->uploadImage2($request->file('img11'), $path);
            $kelahiran->persyaratan->update([
                'img11' => $request->file('img11')->hashName(),
            ]);
        }
        if($request->file('img12')){
            Storage::disk('local')->delete($path. basename($kelahiran->persyaratan->img12));
            $this->uploadImage2($request->file('img12'), $path);
            $kelahiran->persyaratan->update([
                'img12' => $request->file('img12')->hashName(),
            ]);
        }
        if($request->file('dokumen')){
            Storage::disk('local')->delete($path. basename($kelahiran->dokumen));
            $this->uploadImage2($request->file('dokumen'), $path);
            $kelahiran->update([
                'dokumen' => $request->file('dokumen')->hashName(),
            ]);
        }
        if($request->file('dokumen_tte')){
            Storage::disk('local')->delete($path. basename($kelahiran->dokumen_tte));
            $this->uploadImage2($request->file('dokumen_tte'), $path);
            $kelahiran->update([
                'dokumen_tte' => $request->file('dokumen_tte')->hashName(),
            ]);
        }
    }

    public function uploadImage($request, $path)
    {
        $image = null;

        if($request->file('image')){
            $image = $request->file('image');
            $image->storeAs($path, $image->hashName());
        }

        return $image;
    }

    public function updateImage($path, $data, $name)
    {
        Storage::disk('local')->delete($path. basename($data->image));

        $data->update([
            'image' => $name,
        ]);
    }
}
