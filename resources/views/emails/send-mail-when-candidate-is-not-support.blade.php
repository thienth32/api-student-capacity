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
    <p> {{ $data?->name ?? "Ứng viên" }} thân mến,</p>
    <br>
    <p>
        Phòng Quan hệ Doanh nghiệp, trường Cao đẳng FPT Polytechnic Hà Nội đã tiếp nhận thông tin của bạn.
    </p>
    <p>
        Hiện tại, phòng chỉ hỗ trợ việc làm cho các bạn sinh viên theo học tại FPT Polytechnic và sinh sống tại Hà Nội.
    </p>
    <p>
        Phòng gửi thông báo để bạn nắm thông tin và chủ động ứng tuyển đến doanh nghiệp khác.
    </p>
    <br>
    <p>Thân mến,</p>
    <p>Phòng QHDN!</p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
