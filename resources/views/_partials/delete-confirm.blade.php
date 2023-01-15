<div class="reveal" id="deleteConfirmation_{{ class_basename($object) . $object->id }}" data-reveal>
    <p>Are you sure you want to delete {!! $label !!}?</p>
    @if (isset($message) && is_array($message))
        <div class="-extra -{{ $message['class'] }}">
            <h4>{{ $message['text'] }}</h4>
        </div>
    @endif
    {!! Form::open(['route' => [$route, $object], 'method' => 'delete']) !!}
    <button class="button secondary" data-close aria-label="Close modal" type="button">Cancel</button>
    {{ Form::submit('Delete', ['class' => 'button alert']) }}
    {!! Form::close() !!}
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<a {!! ((isset($anchor) && $anchor) ? '' : 'class="button alert"') !!}
   data-open="deleteConfirmation_{{ class_basename($object) . $object->id }}">Delete {{ $type }}</a>