<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function generateCourse(Request $request)
    {
        // Instantiate Guzzle client
        $client = new Client();

        // Make API request
        try {
            $response = $client->get('https://vividtutor.mdsyxsqr4v.workers.dev/?course='.$request->input('topic'));

            $apiResponse = json_decode($response->getBody()->getContents(), true);
            $parsedResponse = json_decode($apiResponse['response'], true);

            // Create Course
            $course = Course::create([
                'title' => $parsedResponse['title'],
                'estimated_completion_time' => $parsedResponse['estimated_completion_time'],
                'generated_time' => now(),
                'description' => $parsedResponse['description'],
                'user_id' => Auth::id(),
            ]);

            // Create Chapters
            foreach ($parsedResponse['chapters'] as $index => $chapterData) {
                Chapter::create([
                    'title' => $chapterData['title'],
                    'description' => $chapterData['description'],
                    'content' => '', // Assuming content is the same as description
                    'order' => $index + 1,
                    'completed' => false,
                    'course_id' => $course->id,
                ]);
            }

            return redirect()->route('courses.show', $course->id);

        } catch (\Exception $e) {
            // Log any errors and show an appropriate message
            Log::error('Error generating course: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate course. Please try again later.');
        }
    }

    public function show($id)
    {
        $course = Course::with('chapters')->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function index()
    {
        $courses = Course::where('user_id', Auth::id())->get();
        return view('courses.index', compact('courses'));
    }

    public function dashboard()
    {
        $courses = Course::where('user_id', Auth::id())->get();
        return view('dashboard', compact('courses'));
    }
}
