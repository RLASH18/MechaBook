@extends('emails.layout')

@section('content')
    <h2 style="margin: 0 0 20px 0; color: #333333; font-size: 20px; font-weight: normal;">
        Hello{{ $userName ? ', ' . $userName : '' }}!</h2>

    <p style="margin: 0 0 20px 0; color: #555555; font-size: 14px; line-height: 1.5;">You are receiving this email because we
        received a password reset request for your account.</p>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 25px 0;">
        <tr>
            <td style="text-align: center;">
                <a href="{{ $resetUrl }}"
                    style="display: inline-block; background-color: #1e40af; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: bold;">Reset
                    Password</a>
            </td>
        </tr>
    </table>

    <p style="margin: 20px 0 10px 0; color: #555555; font-size: 14px; line-height: 1.5;">This password reset link will
        expire in <strong>60 minutes</strong>.</p>

    <p style="margin: 0 0 20px 0; color: #555555; font-size: 14px; line-height: 1.5;">If you did not request a password
        reset, no further action is required.</p>

    <div style="background-color: #f5f5f5; padding: 15px; border: 1px solid #e0e0e0; margin-top: 20px;">
        <p style="margin: 0 0 10px 0; color: #666666; font-size: 12px; font-weight: bold;">Having trouble clicking the
            button?</p>
        <p style="margin: 0; color: #1e40af; font-size: 12px; word-break: break-all;">{{ $resetUrl }}</p>
    </div>
@endsection
