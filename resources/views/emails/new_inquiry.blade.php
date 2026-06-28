<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $inquiry->subject ?: ('New ' . ucfirst($inquiry->type) . ' Inquiry') }}</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, Helvetica, sans-serif; color:#0f172a;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:28px 12px; background:#f4f6f8;">
    <tr>
        <td align="center">
            <table width="640" cellpadding="0" cellspacing="0" style="max-width:640px; width:100%; background:#ffffff; border-radius:18px; overflow:hidden; border:1px solid #e5e7eb;">
                <tr>
                    <td style="padding:22px; background:#004D80; color:#ffffff;">
                        <div style="font-size:12px; font-weight:700; letter-spacing:.18em; text-transform:uppercase; opacity:.8;">
                            New Website Inquiry
                        </div>
                        <div style="margin-top:8px; font-size:22px; font-weight:800;">
                            {{ $inquiry->name }}
                        </div>
                        <div style="margin-top:4px; font-size:13px; opacity:.85;">
                            {{ $inquiry->email }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px;">
                        <div style="padding:16px; border-radius:14px; background:#BDBDBD2B; border:1px solid #e5e7eb;">
                            <div style="font-size:12px; font-weight:800; letter-spacing:.12em; color:#711726; text-transform:uppercase;">
                                Inquiry Details
                            </div>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:12px; font-size:14px; color:#334155; line-height:1.7;">
                                <tr>
                                    <td width="120" style="font-weight:700;">Type</td>
                                    <td>{{ ucfirst($inquiry->type) }}</td>
                                </tr>

                                @if($inquiry->subject)
                                    <tr>
                                        <td style="font-weight:700;">Subject</td>
                                        <td>{{ $inquiry->subject }}</td>
                                    </tr>
                                @endif

                                @if($inquiry->phone)
                                    <tr>
                                        <td style="font-weight:700;">Phone</td>
                                        <td>{{ $inquiry->phone }}</td>
                                    </tr>
                                @endif

                                @if($inquiry->company)
                                    <tr>
                                        <td style="font-weight:700;">Company</td>
                                        <td>{{ $inquiry->company }}</td>
                                    </tr>
                                @endif

                                @if($inquiry->product)
                                    <tr>
                                        <td style="font-weight:700;">Product</td>
                                        <td>{{ $inquiry->product->name }}</td>
                                    </tr>
                                @endif

                                @if($inquiry->service)
                                    <tr>
                                        <td style="font-weight:700;">Service</td>
                                        <td>{{ $inquiry->service->title }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td style="font-weight:700;">Submitted</td>
                                    <td>{{ optional($inquiry->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div style="margin-top:18px; padding:18px; border-radius:14px; background:#ffffff; border:1px solid #e5e7eb;">
                            <div style="font-size:12px; font-weight:800; letter-spacing:.12em; color:#004D80; text-transform:uppercase;">
                                Message
                            </div>

                            <div style="margin-top:12px; font-size:14px; line-height:1.8; color:#334155; white-space:pre-line;">
                                {{ $inquiry->message }}
                            </div>
                        </div>

                        <div style="margin-top:22px;">
                            <a href="mailto:{{ $inquiry->email }}"
                               style="display:inline-block; background:#004D80; color:#ffffff; text-decoration:none; padding:12px 18px; border-radius:12px; font-size:14px; font-weight:700;">
                                Reply to Customer
                            </a>

                            <a href="{{ route('admin.inquiries.show', $inquiry->id) }}"
                               style="display:inline-block; margin-left:8px; background:#ffffff; color:#004D80; text-decoration:none; padding:12px 18px; border-radius:12px; font-size:14px; font-weight:700; border:1px solid #dbe3ea;">
                                Open in Admin
                            </a>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:16px 22px; background:#0f172a; color:rgba(255,255,255,.7); font-size:12px;">
                        This notification was sent automatically from the website contact/inquiry form.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>