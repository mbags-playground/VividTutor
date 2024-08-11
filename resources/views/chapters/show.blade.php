<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Chatbot Section -->
                <div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md lg:col-span-1">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Course Chapters</h2>
                        <ul class="space-y-4">
                            @foreach($course->chapters as $courseChapter)
                                <li>
                                    <a href="{{ route('chapters.show', $courseChapter->id) }}" class="flex items-center justify-between text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $courseChapter->order}}.  {{ $courseChapter->title }}
                                        @if($courseChapter->completed)
                                            <span class="text-green-600 dark:text-green-400">✅</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md lg:col-span-1mt mt-2">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Chatbot</h2>
                        <div id="chatbox" class="h-80 overflow-auto flex flex-col-reverse">
                            <div id="messages" class="space-y-4">
                                @foreach($chapter->chatBots as $chat)
                                    <div class="flex justify-end">
                                        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                                            <strong ">
                                                {{ 'You' }}
                                            </strong>
                                            <p>{{$chat->question }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-start">
                                        <div class="p-4 rounded-lg bg-blue-600 text-white">
                                            <strong>
                                                {{ 'System' }}
                                            </strong>
                                            <p>{{$chat->answer }}</p>
                                        </div>
                                    </div>
                                
                                @endforeach
                            </div>
                        </div>

                        <!-- Chat Input Section -->
                        <form id="chat-form" class="mt-4 flex">
                            @csrf
                            <input type="text" id="message" name="message" placeholder="Type your question..." required
                                class="flex-grow px-4 py-2 text-gray-900 dark:text-gray-100 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                Send
                            </button>
                        </form>
                        
                    </div>
                    
                </div>

                <!-- Content Section -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md lg:col-span-2 md:col-span-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4"> {{ $chapter->order }}. {{ $chapter->title }}</h1>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $chapter->description }}</p>
                    <div class="text-gray-700 dark:text-gray-200 mb-4">
                            {!! \Illuminate\Support\Facades\App::make(\League\CommonMark\MarkdownConverter::class)->convertToHtml($chapter->content) !!}
                    </div>

                    <!-- Mark as Complete Button -->
                    @if(!$chapter->completed)
                        <form action="{{ route('chapters.complete', $chapter->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white text-lg font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                                Mark as Completed
                            </button>
                        </form>
                    @else
                        <p class="text-green-600 dark:text-green-400 font-semibold">This chapter is completed!</p>
                    @endif
                </div>

                <!-- Course Chapters Section -->
             
            </div>
        </div>
    </div>

    <!-- Inline Styles -->
    <style>
        /* Hide scrollbar for modern browsers */
        #chatbox::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Internet Explorer, Edge */
        #chatbox {
            -ms-overflow-style: none;  /* IE and Edge */
        }

        /* Hide scrollbar for Firefox */
        #chatbox {
            scrollbar-width: none;  /* Firefox */
        }
    </style>

    <!-- Inline Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatForm = document.getElementById('chat-form');
            const messagesContainer = document.getElementById('messages');
            const messageInput = document.getElementById('message');

            chatForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const message = messageInput.value;
                const formData = new FormData();
                formData.append('message', message);

                fetch("{{ route('chat.send', $chapter->id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const userMessageHtml = `<div class="flex justify-end">
                        <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            <strong>You</strong>
                            <p>${data.question}</p>
                        </div>
                    </div>`;
                    const systemMessageHtml = `<div class="flex justify-start">
                        <div class="p-4 bg-blue-600 text-white rounded-lg">
                            <strong>System</strong>
                            <p>${data.answer}</p>
                        </div>
                    </div>`;

                    // Prepend new messages
                    messagesContainer.innerHTML+=  userMessageHtml+systemMessageHtml;
                    messageInput.value = '';
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</x-app-layout>
