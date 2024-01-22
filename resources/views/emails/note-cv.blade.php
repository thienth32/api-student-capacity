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
    <p>{{ $candidate->name }} thân mến,</p>
    <br>
    <p>Beecareer đã nhận được thông tin và CV từ bạn.</p>
    <p>Chúng tôi có một số góp ý cho CV của bạn như sau:</p>
    <p><strong>{!! $content !!}</strong></p>
    <p>
        Bạn hãy sửa lại CV sau đó ứng tuyển lại
        <a href="{{ config('app.client_url') }}/tin-tuc/{{$post->slug}}?name={{$candidate->name}}&student_code={{$candidate->student_code}}&email={{$candidate->email}}&phone={{$candidate->phone}}">
            tại đây
        </a>
        để cập nhật CV của mình nhé!
    </p>
    <br>
    <p>Thân mến!</p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
