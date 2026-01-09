<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // index
    public function index()
    {
        return view('backend.website.blog.list');
    }

    // List
    public function list()
    {
        $blog = Blog::orderBy('id', 'desc')->get();
        return response()->json($blog);
    }

    // Store
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'short_content' => 'nullable',
                'content' => 'nullable',
            ]);


            $thumbImagePath = null;
            if ($request->hasFile('thumbnail_image')) {
                $thumbImage = 'thumb_' . time() . '.' . $request->thumbnail_image->extension();
                $thumbImagePath = 'uploads/blog/' . $thumbImage;
                $request->thumbnail_image->move(public_path('uploads/blog'), $thumbImage);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $blogImage = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/blog/' . $blogImage;
                $request->image->move(public_path('uploads/blog'), $blogImage);
            }

            // Generate slug from title
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug
            while (Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            // Create blog
            $blog = Blog::create([
                'title' => ucwords($request->title),
                'slug' => $slug,
                'author' => ucwords($request->author),
                'thumbnail_image' => $thumbImagePath,
                'image' => $imagePath,
                'short_content' => $request->short_content,
                'content' => $request->content,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'tags' => $request->tags,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Blog added successfully!',
                'data' => $blog
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to store blog: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return response()->json(['blog' => $blog]);
    }

    // Update
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $blog = Blog::findOrFail($id);

            // Validate inputs
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'short_content' => 'nullable',
                'content' => 'nullable',
            ]);

            // Handle image upload (delete old if exists)
            if ($request->hasFile('thumbnail_image')) {
                if ($blog->thumbnail_image && file_exists(public_path($blog->thumbnail_image))) {
                    unlink(public_path($blog->thumbnail_image));
                }

                $thumbImageName = 'thumb_' . time() . '.' . $request->thumbnail_image->extension();
                $thumbImagePath = 'uploads/blogs/' . $thumbImageName;
                $request->thumbnail_image->move(public_path('uploads/blogs'), $thumbImageName);

                $blog->thumbnail_image = $thumbImagePath;
            }

            if ($request->hasFile('image')) {
                if ($blog->image && file_exists(public_path($blog->image))) {
                    unlink(public_path($blog->image));
                }

                $imageName = time() . '.' . $request->image->extension();
                $imagePath = 'uploads/blogs/' . $imageName;
                $request->image->move(public_path('uploads/blogs'), $imageName);

                $blog->image = $imagePath;
            }

            // Update other fields
            $blog->title = $request->title;

            // Generate slug from title
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug
            while (Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $blog->author = $request->author;
            $blog->short_content = $request->short_content;
            $blog->content = $request->content;
            $blog->meta_title = $request->meta_title;
            $blog->meta_description = $request->meta_description;
            $blog->meta_keywords = $request->meta_keywords;
            $blog->tags = $request->tags;

            $blog->save();

            DB::commit();

            return response()->json([
                'success' => 'Blog updated successfully!',
                'data' => $blog
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update blog: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update active status
    public function toggleStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:blogs,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $blog = Blog::findOrFail($request->id);

            $blog->is_active = $request->status;
            $blog->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $blog
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // Optionally delete image file
            if ($blog->thumbnail_image && file_exists(public_path($blog->thumbnail_image))) {
                unlink(public_path($blog->thumbnail_image));
            }
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            $blog->delete();

            return response()->json(['success' => true, 'message' => 'Blog deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete blog: ' . $e->getMessage()], 500);
        }
    }

    public function blogComments()
    {
        return view('backend.website.blog.blog_comment');
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'website' => 'nullable|prohibited',
        ]);

        // Save the comment
        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->rating = $request->rating;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['success' => true, 'message' => 'Comment submitted successfully.']);
    }

    // Comment List
    public function commentList()
    {
        $comment = BlogComment::with(['blog:id,id,title,slug'])->orderBy('is_active', 'asc')
            ->latest()
            ->get();
        return response()->json($comment);
    }

    // Comment Status
    public function toggleCommentStatus(Request $request)
    {
        // quick validation
        $request->validate([
            'id'     => 'required|integer|exists:blog_comments,id',
            'status' => 'required|boolean'
        ]);

        DB::beginTransaction();

        try {
            $comment = BlogComment::findOrFail($request->id);

            $comment->is_active = $request->status;
            $comment->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'data'    => $comment
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function commentDestroy($id)
    {
        try {
            $comment = BlogComment::findOrFail($id);

            $comment->delete();

            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete comment: ' . $e->getMessage()], 500);
        }
    }

    public function likeBlog(Request $request)
    {
        $blogId = $request->input('blog_id');

        // Get list of liked blog IDs from cookie
        $liked = json_decode($request->cookie('liked_blogs', '[]'), true);

        // Prevent duplicate likes
        if (in_array($blogId, $liked)) {
            return response()->json(['message' => 'You already liked this blog.'], 409);
        }

        // Increment like count
        $blog = Blog::findOrFail($blogId);
        $blog->increment('likes');

        // Update cookie
        $liked[] = $blogId;
        $cookie = Cookie::make('liked_blogs', json_encode($liked), 60 * 24 * 30); // 30 days

        return response()->json([
            'message' => 'Thanks for liking!',
            'likes' => $blog->likes
        ])->cookie($cookie);
    }
}
