<x-app-layout>
    <div class="container mx-auto px-4 py-3 my-4">
        <!-- Course Title and Description -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $course->title }}</h1>
            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $course->description }}</p>
            <p class="text-gray-600 dark:text-gray-400">Estimated Completion Time: <span class="font-semibold">{{ $course->estimated_completion_time }}</span></p>
        </div>

        <!-- Chapters List -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Chapters</h2>
            <ul class="flex flex-col gap-2">
                @foreach($course->chapters as $chapter)
                    <li class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors m-2">
                        <a href="{{ route('chapters.show', $chapter->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            {{ $chapter->order}}. {{ $chapter->title }}
                        </a>
                        @if($chapter->completed)
                            <span class="text-green-600 dark:text-green-400">✅</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
