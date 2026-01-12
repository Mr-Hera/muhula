<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>New Contact Message | Muhula</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
            <tr>
                <td align="center">

                    <!-- Main container -->
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:6px; overflow:hidden;">

                        <!-- Header -->
                        <tr>
                            <td style="background-color:#1f3c88; padding:20px 30px;">
                                <h1 style="margin:0; color:#ffffff; font-size:22px;">
                                    Muhula
                                </h1>
                                <p style="margin:5px 0 0; color:#dbe4ff; font-size:14px;">
                                    Contact Us Notification
                                </p>
                            </td>
                        </tr>

                        <!-- Body -->
                        <tr>
                            <td style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">

                                <p style="margin-top:0;">
                                    You have received a new message through the <strong>Contact Us</strong> form on <strong>Muhula</strong>.
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px; border-collapse:collapse;">
                                    <tr>
                                        <td style="padding:8px 0; width:160px; font-weight:bold;">Full Name:</td>
                                        <td style="padding:8px 0;">{{ $data['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px 0; font-weight:bold;">Email Address:</td>
                                        <td style="padding:8px 0;">{{ $data['email'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px 0; font-weight:bold;">Phone Number:</td>
                                        <td style="padding:8px 0;">{{ $data['phone'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px 0; font-weight:bold;">Subject:</td>
                                        <td style="padding:8px 0;">{{ $data['subject'] }}</td>
                                    </tr>
                                </table>

                                <hr style="border:none; border-top:1px solid #e5e7eb; margin:25px 0;">

                                <p style="margin-bottom:8px; font-weight:bold;">Message:</p>

                                <div style="background-color:#f9fafb; border:1px solid #e5e7eb; padding:15px; border-radius:4px;">
                                    {{ $data['message'] }}
                                </div>

                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="background-color:#f9fafb; padding:20px 30px; font-size:12px; color:#666666;">
                                <p style="margin:0;">
                                    Muhula simplifies the search and access to information about learning institutions and education partners for parents and students, regardless of their educational journey.
                                </p>
                                <p style="margin:10px 0 0;">
                                    This message was sent from the Muhula contact form.
                                </p>
                            </td>
                        </tr>

                    </table>
                    <!-- End container -->

                </td>
            </tr>
        </table>

    </body>
</html>
