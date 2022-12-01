@foreach ($requirements as $requirement)
{{ $requirement->tool->name }}, {{ $requirement->years }} {{ Str::plural('year', $requirement->years) }}, {{ $requirement->optional ? 'optional' : 'required' }}
{{ filled($requirement->summary) ? $requirement->summary : 'No specific needs mentioned.' }}
@endforeach