<div class="table" style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
<table style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto 35px; width: 100%; border-spacing: 0;">
<thead style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
<tr>
<th style="box-sizing: border-box; position: relative; border-bottom: 2px solid #BBE1C1; margin: 0; padding: 10px 15px 6px; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: 600; font-size: 12px; text-align: left; color: #8795A1;">Tool</th>
<th style="box-sizing: border-box; position: relative; border-bottom: 2px solid #BBE1C1; margin: 0; padding: 10px 15px 6px; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: 600; font-size: 12px; text-align: left; color: #8795A1;">Experience</th>
<th align="center" style="box-sizing: border-box; position: relative; border-bottom: 2px solid #BBE1C1; margin: 0; padding: 10px 15px 6px; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: 600; font-size: 12px; color: #8795A1; text-align: center;">Required</th>
</tr>
</thead>
<tbody style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
@foreach ($requirements as $requirement)
<tr>
<td style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 15px">{{ $requirement->tool->name }}</td>
<td style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 15px">{{ $requirement->years }} {{ Str::plural('year', $requirement->years) }}</td>
<td align="center" style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; background-color: #FAFCFD; color: #74787e; font-size: 14px; line-height: 18px; margin: 0; padding: 15px">@component('mail::pill', ['color' => $requirement->optional ? 'green' : 'orange', 'text' => $requirement->optional ? 'No' : 'Yes'])@endcomponent</td>
</tr>
<tr>
<td colspan="3" style="box-sizing: border-box; font-family: Verdana, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; background-color: #FFFFFF; color: #74787e; font-size: 13px; line-height: 25px; margin: 0; word-break: break-all; {{ $loop->last ? 'padding: 15px 25px 0' : 'border-bottom: solid 1px #e6e9eb; padding: 15px 25px 30px' }}">{{ filled($requirement->summary) ? $requirement->summary : 'No specific needs mentioned.' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>