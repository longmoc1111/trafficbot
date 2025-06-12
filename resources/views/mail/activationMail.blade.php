<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kích hoạt tài khoản</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 30px; text-align: center;">
                <h2 style="color: #333;">Xác minh địa chỉ Email của bạn</h2>
                <p style="font-size: 16px; color: #555;">Xin chào {{ $user->name ?? 'Người dùng' }},</p>
                <p style="font-size: 16px; color: #555;">
                    Cảm ơn bạn đã đăng ký. Vui lòng nhấn nút bên dưới để xác minh địa chỉ email của bạn và kích hoạt tài khoản.
                </p>
                <p style="margin: 30px 0;">
                    <a href="{{ url("activate/$token") }}" style="background-color: #28a745; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                        Kích hoạt
                    </a>
                </p>
                <p style="font-size: 14px; color: #888;">Nếu bạn không tạo tài khoản, hãy bỏ qua email này.</p>
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
