<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>{{env('APP_NAME')}} - Ingresso Online</title>
    <style>
        @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
        body {
            font-family: Elegance, sans-serif;
            color: #666;
        }
    </style>
</head>
<body style="background-color: #666; padding: 20px 20px 0 20px;">
<div style="display: block; text-align: center"><img src="{{$logo}}"></div>

<br>
<div>
    <img src="{{asset('qrcodes/'.$img)}}" style="border-radius: 8px">
    <div style="background: #fffc00; width: 100%; height: auto; border-radius: 8px; text-align: center; ">
        <p style="font-size: 15px; padding-top: 5px">
            {{$ticket->event->name}}
        <hr>
        <div style="font-size: 30px; padding: 5px 0">{{date("d/m/Y - H:i", strtotime($ticket->event->date))}}</div>
        <hr>
        <div style="font-size: 15px; padding: 5px 0 10px 0">{{substr(md5($ticket->id), 0, 20)}}_{{$ticket->id}}</div>
        </p>

    </div>

    <br>
</div>
</body>
</html>
