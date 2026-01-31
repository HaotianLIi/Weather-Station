@foreach($students as $student)
    <p>{{ $student -> name }}</p>
@endforeach

<?php foreach ($students as $student) { ?>
    <p> {{ $student -> name }}</p>
<?php} ?>
