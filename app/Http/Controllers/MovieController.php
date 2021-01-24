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
        //$this->middleware(MovieMiddleware::class);
    }

    //show all  Movies
    public function all()
    {

        //if you  want get data from an other database just  use this method
     // $movies = DB::connection('mysql2')->select('select * from actors');

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
        $req= implode(",",$request->actors);
        $actors=DB::connection('mysql2')->select("select id ,name from actors where id in ($req)  ");
        $actors=json_encode($actors);
        $actors=serialize($actors);
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

        $req= implode(",",$request->actors);
        $actors=DB::connection('mysql2')->select("select id ,name from actors where id in ($req)  ");
        $actors=json_encode($actors);
        $actors=serialize($actors);
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

    //list the films of an actor and  his {id}
    public function actorMovies($id){


        $movies = Movie::all();
        $moviesActor = [];

        foreach($movies as $m) {

            $actors = json_decode(unserialize($m->actors));

            foreach($actors as $a) {

                if($a->id == $id) {
                    $moviesActor[] = $m;
                }
            }
        }

       // dd(response()->json($moviesActor));
        return response()->json($moviesActor);
        //return response($moviesActor, 200);

    }


}
