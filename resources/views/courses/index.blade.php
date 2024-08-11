
<x-dashboard-layout>
<div class="container">
    <h1>Your Courses</h1>
    <ul>
        @foreach($courses as $course)
            <li><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        @endforeach
    </ul>
</div>
</x-dashboard-layout>
