<?php

namespace App\Http\Controllers\API;


use App\ConfigApp;
use App\GiftRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GiftRequestsController extends Controller
{
    /**
     * @var GiftRequests
     */
    private $giftRequests;

    public function __construct(GiftRequests $giftRequests)
    {
        $this->giftRequests = $giftRequests;
    }

    public function statusUpdate(Request $request)
    {
        $contract_id = Auth::user()->userable->contract_id;
        $user_id = Auth::user()->id;
        $id = $request->get('id');
        $status = $request->get('status');
        $update = $this->giftRequests->find($id);
        if(empty($contract_id) || ($update->contract_id != $contract_id)){
            return ['success' => false];
        }
        if($update){
            $update->statusHistoric()->create(['giftrequest_id' => $update->id, 'user_id' => $user_id, 'status' => $status]);
            $update->status = $status;
            $update->save();

            $dataStatusHistoricArray = [];
            foreach($update->statusHistoric()->orderBy('created_at', 'desc')->get() as $re){
                $dataStatusHistoric = [
                    'date' => date("d/m/Y H:i", strtotime($re->created_at)),
                    'status' => ConfigApp::GiftRequetsStatus()[$re->status],
                    'user' => $re->user->name,
                ];

                $dataStatusHistoricArray[] = $dataStatusHistoric;
            }
            return ['success' => true, 'data' => $dataStatusHistoricArray];
        }else{
            return ['success' => false];
        }
    }

}
