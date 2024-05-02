<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return view('dashboard.blog', [
            "blogs" => $blogs
        ], compact('blogs'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'attachment' => 'file|mimes:jpeg,png,pdf|max:2048',
            'tags' => 'required|string|max:255',
            'contents' => 'required|string',
            'status' => 'required|in:Created,Processing,Published',
        ]);

        // Mengunggah gambar jika ada
        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('storage/attachment'), $attachmentName);

            // Tambahkan nama file attachment ke dalam array data
            $data['attachment'] = $attachmentName;
        }


        // Create the blog record in the database
        $data = [
            'title' => $request->title,
            'date' => $request->date,
            'tags' => $request->tags,
            'contents' => $request->contents,
            'status' => $request->status,
        ];

        // Check if 'attachment' exists before adding it to the data array
        if ($attachmentName !== null) {
            $data['attachment'] = $attachmentName;
        }

        Blog::create($data);
        return redirect()->back()->with('status', 'Data created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Blog::find($id);
        // Lakukan validasi jika proyek tidak ditemukan
        if (!$project) {
            return redirect()->back()->with('error', 'blogs not found.');
        }
        return view('dashboard,blog.view', compact('blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blogs = Blog::find($id);
        // Lakukan validasi jika proyek tidak ditemukan
        if (!$blogs) {
            return redirect()->back()->with('error', 'blogs not found.');
        }
        return view('dashboard,blog.edit', compact('blogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blogs = Blog::find($id);
        // Lakukan validasi jika proyek tidak ditemukan
        if (!$blogs) {
            return redirect()->back()->with('error', 'Blog not found.');
        }
        $blogs->delete();
        return redirect()->route('dashboard.blog')->with('status', 'blogs deleted successfully.');
    }
}
