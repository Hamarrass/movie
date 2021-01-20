<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MovieMiddleware;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{

    public function __construct()
    {
        $this->middleware(MovieMiddleware::class);
    }

    //show all  Movie
    public function all()
    {
        return response()->json(Movie::all());
    }

    //show one Movie
    public function read($id)
    {
        return response()->json(Movie::find($id));
    }

    //create  new Movie
    public function create(Request $request)
    {

        $actors=serialize($request->actors);
        $movie = new Movie();
        $movie->name   = $request->name;
        $movie->year   = $request->year ;
        $movie->actors = $actors ;
        $movie->save();
        return response()->json("Created successfully id=".$movie->id, 201);

    }

    //update Movie info
    public function update($id, Request $request)
    {

        $actors=serialize($request->actors);
        $movie = Movie::findOrFail($id);
        $movie->name   = $request->name;
        $movie->year   = $request->year ;
        $movie->actors = $actors ;
        $movie->save();

        return response()->json($movie, 200);
    }

    //delete Movie
    public function delete($id)
    {
        Movie::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    //list all movies for a given year
    public function moviesByYear($year)
    {
       $movies = Movie::where('year', $year)->get();
        return response($movies, 200);
    }

    //list the films of an actor by his {id}
    public function actorMovies($actor ,Request $request){


        $movies = Movie::all();
        $moviesActor = [];

        foreach($movies as $m) {

            $actors = unserialize($m->actors);

            foreach($actors as $a) {
                if($a["id"] == $actor) {
                    $moviesActor[] = $m;
                }
            }
        }

        return response($moviesActor, 200);

    }


}
