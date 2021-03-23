<?php

namespace App\Http\Controllers\Portal;

use App\Forming;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    public function index(){

        $formando = Auth::user()->userable->id;
        $forming = Forming::find($formando);

        $public = 'img/portal/formings/photos-upload/' . $forming->contract_id . '/' . $forming->id;
        $path = public_path($public);
        $photos = [];
        if(is_dir($path)){
            $openDir = opendir($path);
            $photos = [];
            while ($file = readdir($openDir)){
                if($file == '.' || $file == '..' || $file == '.DS_Store') continue;
                $photos[] = $file;
            }
        }


        return view('portal.photos.index', compact('photos', 'public'));
    }

    public function upload(Request $request)
    {

        $formando = Auth::user()->userable->id;
        $forming = Forming::find($formando);

        $path = public_path('img/portal/formings');
        if(!is_dir($path)){
            mkdir($path);
        }

        $path = public_path('img/portal/formings/photos-upload/');
        if(!is_dir($path)){
            mkdir($path);
        }

        $path = public_path('img/portal/formings/photos-upload/' . $forming->contract_id);
        if(!is_dir($path)){
            mkdir($path);
        }
        $path = public_path('img/portal/formings/photos-upload/' . $forming->contract_id . '/' . $forming->id);
        if(!is_dir($path)){
            mkdir($path);
        }

        $validatedData = $this->validate($request, [
            'foto_crianca' => 'required|image|mimes:jpeg,jpg|max:2048',
            'foto_familia' => 'required|image|mimes:jpeg,jpg|max:2048',
        ]);

        $formingName = $forming->nome . '' . $forming->sobrenome;
        $formingName = str_slug(snake_case($formingName));
        $image1 = 'crianca-'. $formingName . '.'.request()->foto_crianca->getClientOriginalExtension();
        $image2 = 'familia-'. $formingName . '.'.request()->foto_familia->getClientOriginalExtension();
        $image3 = 'livre-'. $formingName . '.'.request()->foto_livre->getClientOriginalExtension();
        $crianca = $request->file('foto_crianca');
        $familia = $request->file('foto_familia');
        $livre = $request->file('foto_livre');
        move_uploaded_file($crianca->getRealPath(), $path.'/'.$image1);
        move_uploaded_file($familia->getRealPath(), $path.'/'.$image2);
        move_uploaded_file($livre->getRealPath(), $path.'/'.$image3);

        return redirect()->route('portal.photos');
    }
}
