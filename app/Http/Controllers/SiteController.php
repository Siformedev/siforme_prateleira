<?php

namespace App\Http\Controllers;

use App\SimulationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;
use Session;
use RealRashid\SweetAlert\Facades\Alert;


class SiteController extends Controller
{
    public function __construct()
    {
        $this->client = new Client([
            
        ]);
    }
    protected function home()
    {
        
 //        Session::flash('warning', 'N�o foi poss�vel enviar a sua  mensagem');



        //$toast_success = array('toast_success' => 'Task Created Successfully!');
        //return view('site.home');
        return \View::make('site.home')->withSuccess('Task Created Successfully!');
        //return redirect('site.home')->withSuccess('Task Created Successfully!');

        // return redirect()->action('${App\Http\Controllers\Auth\LoginController@login}');


    }

    protected function simulacao()
    {
        return view('site.simulacao');
    }

    protected function contato(Request $request){
        $fromMail = 'contato@siforme.com.br';
        $fromName = 'Siforme';
        $dataEmail = ($request->all());

        $recaptcha = $this->check_recaptcha($request->get('g-recaptcha-response'));
        
        if( isset($recaptcha->motivo) ){
            //dd('aqui');
            Alert::error('Ops!', $recaptcha->motivo);
            return redirect()->route('site.home');
        }


        //dd($dataEmail);
        $destinatario = (object) array('nome' => '', 'email' => $dataEmail['email']);
        
        Mail::send('email.contato-site', $dataEmail, function ($message) use ($fromName, $fromMail, $destinatario){
            $message->to('contato@siforme.com.br');
            $message->cc('adalbertoandreoli@gmail.com');
            $message->bcc('lescoderbr@gmail.com');
            
            $message->from($fromMail, $fromName);
            $message->subject('Contato site!');
            //$message->attach(public_path('contrato_GABRIEL_BICALHO.pdf'))
        });
        
        Alert::success('Obrigado', 'Sua mensagem foi enviada para nossa equipe');

        return redirect()->route('site.home');
    }

    public function simulacaoStore(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'cellphone' => 'required',
            'institution' => 'required',
            'course' => 'required',
            'commission' => 'required',
        ]);

        $data = $request->all();
        $data = $this->removeFieldToken($data);
        $simulation_request = SimulationRequest::create($data);
        Mail::to($data['email'])->send(new \App\Mail\SimulationRequest($data));
        if($simulation_request){
            \Session::flash('msg-ok', 'Seu cadastro foi enviado com sucesso! Verifique seu email!');
        }else{
            \Session::flash('msg-error', 'Erro ao concluir cadastro!');
        }
        return redirect()->route('site.simulacao');
    }


    /**
     * PRIVATE FUNCTIONS
     */
    private function removeFieldToken(array $data){
        unset($data['_token']);
        return $data;
    }

    function check_recaptcha($recaptcha){

        try {
            $response = $this->client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => array(
                'secret' => '6Lc5V_IUAAAAAKATh4fat1PwTn0M7dO4-FHvvhWa',
                'response' => $recaptcha,
                )
            ]);
            
            $response = \GuzzleHttp\json_decode($response->getBody()->getContents());
            
            if(!$response->success){
                $response->motivo = "Não passou na verificação do recaptcha";
            }

        }catch (\Exception $exception) {
            //var_dump ($exception->getMessage());
            //$response = json_decode($e->getResponse());
            //return $response;            
            //Alert::error('Ops!', $exception->getMessage());
            //return redirect()->route('site.home');
            $response->motivo = $exception->getMessage();
        }
        return $response;
    }

}
