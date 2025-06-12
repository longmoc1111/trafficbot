<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 30px; text-align: center;">
                <h2 style="color: #333;">Yêu cầu đặt lại mật khẩu</h2>
                <p style="font-size: 16px; color: #555;">Xin chào {{ $user->name ?? 'Người dùng' }},</p>
                <p style="font-size: 16px; color: #555;">
                    Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình. Nhấn vào nút bên dưới để tiến hành đặt lại:
                </p>
                <p style="margin: 30px 0;">
                    <a href="{{ url("/reset_password/$token") }}?email={{ urlencode($user->email) }}"
                       style="background-color: #007bff; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                        Đặt lại mật khẩu
                    </a>
                </p>
                <p style="font-size: 14px; color: #888;">
                    Liên kết này sẽ hết hạn sau 60 phút
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center; font-size: 12px; color: #999;">
                © {{ date('Y') }} All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
