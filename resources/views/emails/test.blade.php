<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Email</title>
</head>
<body style="margin:0; padding:0; background:#f6f8fb; font-family: Arial, Helvetica, sans-serif; color:#0f172a;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f8fb; padding: 28px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="640" cellpadding="0" cellspacing="0" style="width:640px; max-width: 100%; background:#ffffff; border:1px solid rgba(0,0,0,0.08); border-radius:16px; overflow:hidden;">
                <tr>
                    <td style="padding: 18px 22px; background:#004D80; color:#ffffff;">
                        <div style="font-size: 14px; letter-spacing: .08em; font-weight: 700; text-transform: uppercase; opacity: .92;">Industrial Site</div>
                        <div style="margin-top: 6px; font-size: 18px; font-weight: 700;">Test Email</div>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 22px;">
                        <div style="font-size: 14px; color:#334155;">This is a test email to verify your mail configuration is working.</div>

                        <div style="margin-top: 18px; padding: 14px 14px; border-radius: 14px; background: rgba(189,189,189,0.17); border: 1px solid rgba(0,0,0,0.06);">
                            <div style="font-size: 12px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color:#004D80;">Details</div>
                            <div style="margin-top: 8px; font-size: 13px; color:#334155; line-height: 1.6;">
                                <strong>Mailer:</strong> {{ config('mail.default') }}<br>
                                <strong>Host:</strong> {{ config('mail.mailers.smtp.host') }}<br>
                                <strong>Port:</strong> {{ config('mail.mailers.smtp.port') }}<br>
                                <strong>From:</strong> {{ config('mail.from.address') }}<br>
                                <strong>Sent at:</strong> {{ $time }}
                            </div>
                        </div>

                        <div style="margin-top: 20px; font-size: 13px; color:#475569;">
                            If you received this email, your mail configuration is working correctly.
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 14px 22px; background:#0b1220; color: rgba(255,255,255,0.75); font-size: 12px;">
                        This is a test email from the Industrial Site application.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
