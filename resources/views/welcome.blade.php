<x-guest-layout>   
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-12 bg-white dark:bg-gray-900 transition-colors duration-300">
        <h1 class="text-4xl md:text-5xl font-bold text-center mb-6 text-gray-900 dark:text-white">
            Next Level AI Tutoring<br>for Life-Long Learners
        </h1>
        <p class="text-xl text-center mb-12 max-w-2xl mx-auto text-gray-700 dark:text-gray-300">
            Create a custom learning pathway to help you achieve more in school, work, and life.
        </p>
        <div class="max-w-3xl mx-auto mb-12">
            <form action="{{ route('generate.chapter') }}" method="POST" >
                <div class="flex flex-col md:flex-row gap-4">

                    @csrf
                    <input type="text" name="topic" placeholder="Enter a topic to generate a course" required
                    class="flex-grow px-6 py-4 text-lg border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700">
                    
                    <button type="submit" 
                    class="px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                    Generate Course
                </button>
                </div>
                <div class="text-center mb-16">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Popular topics:</h2>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">Programming</a>
                        <a href="#" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">Walking meditation</a>
                        <a href="#" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">How to be happy</a>
                    </div>
                </div>
        
            </form>
         
        </div>
        <div class="container mx-auto mt-8 px-4">
            @auth

           
                
                
        
               
        
              
                <footer class="text-center text-sm text-gray-600 dark:text-gray-400">
                    <nav class="mb-4">
                        <a href="#" class="hover:underline mx-2">Tutor AI</a>
                        <a href="#" class="hover:underline mx-2">Free Online Courses</a>
                        <a href="#" class="hover:underline mx-2">Pricing</a>
                        <a href="#" class="hover:underline mx-2">Affiliate Program</a>
                        <a href="#" class="hover:underline mx-2">Contact Us</a>
                        <a href="#" class="hover:underline mx-2">Changelog</a>
                        <a href="#" class="hover:underline mx-2">About Us</a>
                        <a href="#" class="hover:underline mx-2">Privacy Policy</a>
                        <a href="#" class="hover:underline mx-2">Terms & Conditions</a>
                    </nav>
                    <p>&copy; {{ date('Y') }} Vivid Tutor. All rights reserved.</p>
                </footer>
                
            @else
                <h1 class="text-3xl font-bold text-center">Welcome to Vivid Tutor</h1>
                <p class="text-center mt-4">Please log in to generate course chapters.</p>
            @endauth
        </div>
    </div>
</x-guest-layout>