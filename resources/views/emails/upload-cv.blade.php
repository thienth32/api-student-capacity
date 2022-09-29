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
        <h2> Xin chào , {{ $data->name }}</h2>
        <p>Hồ sơ của bạn đã được gửi thành công . Nhà tuyển dụng
            sẽ liên hệ với bạn trong thời gian sớm nhất nếu hồ sơ của
            bạn phù hợp và đáp ứng yêu cầu tuyển dụng. </p>
        <a href="https://viblo.asia/p/luu-va-gui-notification-real-time-trong-laravel-OeVKB3x0ZkW">Liên kết đường dẫn
            hỗ sơ</a>
        <br>
        <h3>Chúc {{ $data->name }} Một ngày tốt lành .</h3>
    </div>
</body>

</html>
