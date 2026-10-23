<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
<div class="container">
    <p>{{ $candidate ?? "Ứng viên" }} thân mến,</p>
    <p>Phòng QHDN đã nhận được CV ứng tuyển của em, tuy nhiên vị trí tuyển dụng <strong>{{$codeRecruitment}} - {{$position}} - {{$enterprise}}</strong> đã tuyển đủ số lượng nhân sự.</p>
    <p>Em vui lòng lựa chọn vị trí ứng tuyển khác phù hợp để ứng tuyển nhé.</p>
    <p>Trân trọng,</p>
    <p>Phòng QHDN!</p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
