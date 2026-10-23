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
    <p>{{ $data->name }} thân mến,</p>
    <br>
    <p>Beecareer đã nhận được CV ứng tuyển của bạn. Xem lại hồ sơ đã ứng tuyển
        <a href="{{ Storage::disk('s3')->temporaryUrl($data->file_link, now()->addMinutes(5)) }}">tại đây</a>
    </p>
    <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
    <p>Trong thời gian đợi phản hồi, bạn có thể tìm hiểu thêm các mã tuyển dụng khác thuộc ngành
        <a href="{{ config('app.client_url') }}/tin-tuc-tuyen-dung?major_id={{$data->major_id}}">
            {{ $data->major->name }}
        </a>
    </p>
    <br>
    <p>Thân mến!</p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
