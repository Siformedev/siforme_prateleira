
<div style="background: #666666; text-align: center; padding: 10px; margin: 5px; width: 300px; display: inline-block;">
    <div class="col-sm-12" style="margin-bottom: 10px"><img style="width: 200px; border: 3px solid #fffc00; border-radius: 100px; background: #ffffff" src="{{$formando->img}}"></div>
{{--    <img src="" style="border-radius: 8px">--}}
    <div class="col-sm-12 col-lg-12" style="background: #fffc00; display: block; border-radius: 8px; text-align: center; margin-top: 10px; margin-bottom: 7px; ">

        {!! QrCode::size(250)->margin(2)->generate($formando->valid); !!}
        <hr style="margin: 0">
        <div style="font-size: 24px; height: 40px; overflow: hidden; padding: 3px;">{{$formando->nome}} {{$formando->sobrenome}}</div>

    </div>
</div>
