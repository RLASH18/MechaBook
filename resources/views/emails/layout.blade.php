<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject ?? 'MechaBook' }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td>
                <!-- Main Container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 500px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1e40af; padding: 20px; text-align: center;">
                            <img src="{{ asset('img/mecha-book-logo-removebg.png') }}" alt="MechaBook" style="max-width: 60px; height: auto;">
                            <h1 style="margin: 10px 0 0 0; color: #ffffff; font-size: 18px; font-weight: normal;">MechaBook</h1>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px 20px;">
                            @yield('content')
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 15px 20px; text-align: center; border-top: 1px solid #e0e0e0;">
                            <p style="margin: 0; color: #666666; font-size: 12px;">&copy; {{ date('Y') }} MechaBook. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
