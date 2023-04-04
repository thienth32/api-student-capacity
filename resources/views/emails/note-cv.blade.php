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
        <h2> Xin chào , {{ $candidate->name }}</h2>
        <p>{{$content}}</p>
        <a href="{{ env('CLIENT_URL') }}/tin-tuc/{{$post->slug}}?name={{$candidate->name}}&student_code={{$candidate->student_code}}&email={{$candidate->email}}&phone={{$candidate->phone}}">
            Cập nhật hồ sơ tại đây
        </a>
        <br>
        <h3>Chúc {{ $data->name }} Một ngày tốt lành .</h3>
    </div>
</body>

</html>
