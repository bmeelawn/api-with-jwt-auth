<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'title' => $request->title,
            'description' => $request->description
        ]);
        
        $book = Book::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);
        
        // return BookResource($book);
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        // check if authenticated user is the owner of book
        if($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can edit your own books.'], 403);
        }

        $book->update($request->only(['title', 'description']));

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
