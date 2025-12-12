<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { color: #667eea; margin: 0; }
        .content { margin: 20px 0; }
        .button { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 4px; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>Reset Password</h2>
            </div>

            <div class="content">
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah untuk melanjutkan:</p>

                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ $resetUrl }}" class="button">Reset Password</a>
                </p>

                <p>Atau copy link berikut ke browser Anda:</p>
                <p style="word-break: break-all; color: #667eea;">{{ $resetUrl }}</p>

                <p style="margin-top: 30px; color: #d32f2f;">
                    <strong>Perhatian:</strong> Link ini hanya berlaku selama 60 menit. Jika Anda tidak melakukan permintaan ini, abaikan email ini.
                </p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} CRUD Laravel. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>
</body>
</html>
