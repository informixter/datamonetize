<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\ProductCollection;
use App\Products;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function youtube(Request $request)
    {
        if (!$request->has('id')) {
            return ErrorResource::error("Нет поля запроса id видео");
        }

        $client = new Client();

        $res = $client->request('GET', 'http://transcript:8080?' . $request->get('id'));
        $keys = json_decode($res->getBody()->getContents(), true);
        $keys = array_keys($keys);
        if (count($keys) == 0) {
            return ErrorResource::error("Нет субтитров");
        }
        $k = "'" . implode("', '", $keys) . "'";
        $sql = "select r.cat_key, count(*) as count
                from (
                         select (select cat_key
                                 from (select cat_key, levenshtein(search, keys.rows) as score
                                       from key_words
                                       order by score asc
                                       limit 1) as pre
                                 where pre.score <= 1) as cat_key
                         from (
                                  select unnest(ARRAY [".$k."]) as rows
                              ) as keys
                     ) as r
                WHERE r.cat_key notnull group by r.cat_key order by r.cat_key desc;";
        $res = DB::select($sql);

        if (count($res) == 0){
            return ErrorResource::error("Нет подходящих продуктов");
        }

        $search = [];
        foreach ($res as $row){
            $search[] = [
                'category' => $row->cat_key,
                'products' => new ProductCollection(Products::where('key', $row->cat_key)->limit(5)->orderBy('price', 'asc')->get())
            ];
        }

        return response()->json($search, 200);
    }

    public function search(Request $request)
    {
        if (!$request->has('query')) {
            return ErrorResource::error("Нет поля запроса");
        }

        $result = Products::search($request->get("query"))->paginate(20);
        return new ProductCollection($result);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Products $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
}
