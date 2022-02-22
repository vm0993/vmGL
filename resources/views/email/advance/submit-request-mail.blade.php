@component('mail::message')
Hi {{ $details['user'] }} ,

{{ $details['user'] }} submited this request for verified.

Request No : {{ $details['request']->code }}<br>
Request Date : {{ \Carbon\Carbon::parse($details['request']->transaction_date)->format('d M y') }}<br>
Request Description : {{ $details['request']->description }}<br>
Request Amount : {{ number_format($details['request']->request_amount) }}<br>

Detail Request :<br>
<table>
    <thead>
        <tr>
            <th style="text-align:left;">Detail</th>
            <th style="text-align:right;">Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($details['requests'] as $item)
            <tr>
                <td style="text-align: left;">
                    {{ $item->cost->name }}<br>{!! $item->note !!}
                </td>
                <td style="text-align: right;">{{ number_format($item->amount) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td style="font: bold;text-align:left;">
                Total
            </td>
            <td style="font: bold;text-align: right">{{ number_format($details['requests']->sum('amount')) }}</td>
        </tr>
    </tfoot>
</table><br>

if you want to approved this request please login {{ env('SITE_URL') }} and Approve from Advance Request menus.

This is an automated system email. Please do not reply to this email.

Visit our website at {{ env('SITE_URL') }} to learn more about us, or contact our support at {{ env('MAIL_SUPPORT') }}.

Thank you.


Sincerely,<br>
{{ config('app.name') }}
@endcomponent
