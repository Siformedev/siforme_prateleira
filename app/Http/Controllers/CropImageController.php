<?php

namespace App\Http\Controllers;

use App\Forming;
use App\Helpers\CropAvatar;
use Illuminate\Http\Request;

use App\Http\Requests;

class CropImageController extends Controller
{

    private $avatar_src;
    private $avatar_data;
    private $avatar_file;

    public function crop(Request $request){


        $this->avatar_src = $request->input('avatar_src');
        $this->avatar_data = $request->input('avatar_data');
        $this->avatar_file = $_FILES['avatar_file'];


        $crop = new CropAvatar(
            isset($this->avatar_src) ? $this->avatar_src : null,
            isset($this->avatar_data) ? $this->avatar_data : null,
            isset($this->avatar_file) ? $this->avatar_file : null
        );

        $response = array(
            'state' => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult()
        );

        return $response;
    }
    public function fotoupdate(Request $request)
    {
        $img = $request->get('img');        
        //$img_file = str_replace('img/temp', '', $img);
        $img_file = explode('/', $img);
        //dd($img_file);
        //dd($img);

        //$img = public_path($img);

        if(!(auth()->check())){

        }else{
            
            if(file_exists($img)){
                //$new_local = '/upload/img/perfil/'.$img_file;
                $new_local = '/upload/img/perfil/';
                if (!file_exists(public_path($new_local))) {
                    mkdir(public_path($new_local), 0777, true);
                    //dd(file_exists($new_local));
                }
                $new_local .= end($img_file);
                
                rename($img, public_path($new_local));
                $formando = Forming::find(auth()->user()->userable->id);
                $formando->img = $new_local;
                $formando->save();
                return $formando;

            }


        }

    }
}
