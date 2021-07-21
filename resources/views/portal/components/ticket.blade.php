
<div style="background: #666666; text-align: center; padding: 10px; margin: 5px; width: 300px; display: inline-block">
    <div class="col-sm-12" style="margin-bottom: 10px"><img src="{{$logo}}"></div>
{{--    <img src="" style="border-radius: 8px">--}}
    <div class="col-sm-12 col-lg-12" style="background: #fffc00; display: block; border-radius: 8px; text-align: center; margin-top: 10px; margin-bottom: 7px; ">

        {!! QrCode::size(260)->margin(2)->generate($t->code); !!}
        <hr style="margin: 0">
        <div style="font-size: 15px; height: 40px; overflow: hidden; padding: 3px;">{{$e['event']->name}}</div>
        <hr style="margin: 0">
        <div style="font-size: 24px; height: 40px; overflow: hidden">{{date("d/m/Y - H:i", strtotime($e['event']->date))}}</div>
        <hr style="margin: 0">
        <span style="font-size: 12px; padding: 5px 0 10px 0">{{substr(md5($t->id), 0, 20)}}_{{$t->id}}</span>

    </div>
    <div>
        @if($t->checkin == 1)
            <button class="btn btn-success" style="cursor: default"> <i class="fa fa-check" aria-hidden="true"></i> Utilizado</button>
        @elseif($t->checkin == 0)
            <a href="{{route('portal.ticket.save', ['ticket' => $t->code])}}" target="_blank" class="btn btn-info">BAIXAR INGRESSO</a>
        @endif
    </div>
</div>
