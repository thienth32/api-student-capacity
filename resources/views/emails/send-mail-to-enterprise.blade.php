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
    <p>{{ $data?->name ?? "Ứng viên" }} thân mến,</p>
    <br>
    <p>Beecareer đã gửi CV của bạn đến doanh nghiệp.</p>
    <p>Nhà tuyển dụng sẽ liên hệ với bạn trong thời gian sớm nhất nếu hồ sơ của bạn phù hợp và đáp ứng yêu cầu tuyển
        dụng.</p>
    <p>Trong thời gian đợi phản hồi, bạn lưu ý check mail và để ý điện thoại thường xuyên để không bỏ lỡ các thông tin
        quan trọng.</p>
    <br>
    <p>Ngoài ra, Beecareer gửi đến bạn thêm các mã tuyển dụng khác
        @if(empty($data->major_id))
            của
            <a href="{{ config('app.client_url') }}/tin-tuc-tuyen-dung">
                Beecareer
            </a>
        @else
            thuộc ngành
            <a href="{{ config('app.client_url') }}/tin-tuc-tuyen-dung?major_id={{$data->major_id}}">
                {{ $data->major?->name }}
            </a>
        @endif
    </p>
    <br>
    <p>Thân mến!</p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
