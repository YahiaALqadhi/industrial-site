<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $inquiry->reply_subject ?: 'Re: Your inquiry' }}</title>
</head>
<body style="margin:0; padding:0; background:#f6f8fb; font-family: Arial, Helvetica, sans-serif; color:#0f172a;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f8fb; padding:28px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="640" cellpadding="0" cellspacing="0" style="width:640px; max-width:100%; background:#ffffff; border:1px solid #e5e7eb; border-radius:18px; overflow:hidden;">
                
                <tr>
                    <td style="padding:22px 24px; background:#004D80; color:#ffffff;">
                        <div style="font-size:12px; letter-spacing:.16em; font-weight:700; text-transform:uppercase; opacity:.85;">
                            NINGBO PASAFEITE
                        </div>
                        <div style="margin-top:8px; font-size:22px; font-weight:800;">
                            Reply to your inquiry
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px;">
                        <div style="font-size:15px; color:#334155;">
                            Hello <strong>{{ $inquiry->name }}</strong>,
                        </div>

                        <div style="margin-top:16px; padding:18px; border-radius:14px; background:#f8fafc; border-left:4px solid #015EA4;">
                            <div style="font-size:12px; font-weight:700; letter-spacing:.10em; text-transform:uppercase; color:#004D80;">
                                Our Response
                            </div>
                            <div style="margin-top:10px; font-size:14px; line-height:1.75; color:#334155; white-space:pre-line;">{{ $inquiry->reply_message }}</div>
                        </div>

                        <div style="margin-top:20px; padding:16px; border-radius:14px; background:#BDBDBD2B; border:1px solid #e5e7eb;">
                            <div style="font-size:12px; font-weight:700; letter-spacing:.10em; text-transform:uppercase; color:#711726;">
                                Your Original Inquiry
                            </div>

                            <div style="margin-top:10px; font-size:13px; color:#334155; line-height:1.7;">
                                <strong>Subject:</strong> {{ $inquiry->subject ?: '—' }}<br>

                                @if ($inquiry->product)
                                    <strong>Product:</strong> {{ $inquiry->product->name }}<br>
                                @endif

                                @if ($inquiry->service)
                                    <strong>Service:</strong> {{ $inquiry->service->title }}<br>
                                @endif
                            </div>

                            <div style="margin-top:10px; padding-top:10px; border-top:1px solid #e5e7eb; font-size:13px; line-height:1.7; color:#334155; white-space:pre-line;">
                                {{ $inquiry->message }}
                            </div>
                        </div>

                        <div style="margin-top:22px; font-size:13px; line-height:1.7; color:#475569;">
                            Regards,<br>
                            <strong style="color:#0f172a;">NINGBO PASAFEITE Team</strong>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:14px 24px; background:#0b1220; color:rgba(255,255,255,.72); font-size:12px;">
                        This email was sent in response to your inquiry on our website.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>