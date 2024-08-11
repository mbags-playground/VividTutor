<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold">Welcome back, {{ Auth::user()->name }}!</h2>
                </div>
            </div>

            <!-- Courses List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-6">Your Courses</h2>
                    @if($courses->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">You don't have any courses yet. Start by creating one!</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($courses as $course)
                                <li class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-lg font-semibold">
                                        {{ $course->title }}
                                    </a>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $course->created_at->format('M d, Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
