<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Điều chỉnh thông tin ứng tuyển</title>
</head>

<body>
    <div class="container">
        <p>Xin chào, {{ $candidate->name }}</p>
        <br>
        <p>Cảm ơn bạn đã gửi thông tin ứng tuyển tại hệ thống Beecareer thuộc phòng Quan hệ doanh nghiệp trường Cao đẳng FPT Polytechnic.</p>
        <p>Tuy nhiên thông tin ứng tuyển của bạn đang gặp vấn đề: {{$content}}</p>
        <p>
            Vui lòng cập nhật lại thông tin hồ sơ và CV
            <a href="{{ env('CLIENT_URL') }}/tin-tuc/{{$post->slug}}?name={{$candidate->name}}&student_code={{$candidate->student_code}}&email={{$candidate->email}}&phone={{$candidate->phone}}">
                 tại đây.
            </a>
        </p>
        <br>
        <p>Cảm ơn {{ $candidate->name }}!</p>
    </div>
</body>

</html>
