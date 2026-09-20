<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0"
       style="max-width:600px;width:100%;background:#ffffff;margin:40px auto;border-radius:12px;overflow:hidden;">
    <tr>
        <td style="background:#022766;padding:30px;text-align:center;color:#ffffff;">
            <h1 style="margin:0;font-size:24px;">{{ config('app.name') }}</h1>
        </td>
    </tr>
    <tr>
        <td style="padding:35px;color:#1f2937;font-size:15px;line-height:1.5;">
            @yield('content')
        </td>
    </tr>
    <tr>
        <td style="background:#f4f6f8;padding:20px;text-align:center;font-size:12px;color:#666666;">
            @yield('footer', 'Este mensaje fue generado automáticamente desde el sitio web.')
        </td>
    </tr>
</table>
</td></tr>
</table>
</body>
</html>