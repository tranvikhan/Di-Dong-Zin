<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <p>Chào bạn {{ $data['hoTen'] }} </p>
    <p>Chúng tôi gửi cho bạn mật khẩu mới, bạn hãy dùng mật khẩu này để đăng nhập vào hệ thống.
    <p>Đây là mật khẩu mới của bạn:</p>
    <hr><p style="font-size:25px; text-align:center; font-weight:bold;">{{ $data['matKhau'] }}</p><hr>
    <p>Thân chào bạn</p>
    <p>DiDongZin</p>
</body>
</html>
