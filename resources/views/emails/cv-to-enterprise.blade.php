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
    <p>Kính gửi: Quý doanh nghiệp</p>
    <br>
    <p>
        Phòng Quan hệ Doanh nghiệp, trường Cao đẳng FPT Polytechnic xin gửi CV ứng tuyển {{ $post->position }}.
    </p>
    <br>
    <p>
        Anh, chị xem xét CV của sinh viên nếu thấy phù hợp với vị trí công việc của Quý doanh nghiệp thì liên hệ sinh
        viên phỏng vấn và CC email Phòng để bên em nắm được thông tin nhé.
    </p>
    <br>
    <p>
        Ngoài ra, khi Phòng có thêm CV ứng tuyển phù hợp, em sẽ gửi sang thêm cho quý doanh xem xét.
    </p>
    <br>
    <p>
        Trân trọng cảm ơn!
    </p>
    <p>
        Phòng QHDN.
    </p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
