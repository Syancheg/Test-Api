<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Requests\AddAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Requests\DeleteAuthorRequest;

class AuthorController extends Controller
{
    public function index(Request $request){

        $page = $request->input('page') ? $request->input('page') : 1;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $skip = ($page - 1) * $perPage;
        $journals = Author::skip($skip)
            ->take($perPage)
            ->get();

        $result['status'] = 1;
        $result['rows'] = $journals;
        return $result;
    }

    public function add(AddAuthorRequest $request){

        $validate = $request->validated();
        if(!isset($validate['errors'])){
            $result = Author::create($request->all());
        } else {
            $result = $validate;
        }
        return $result;
    }

    public function update(UpdateAuthorRequest $request){

        $validate = $request->validated();
        if(!isset($validate['errors'])){
            $author = Author::find($request['id']);
            $author->name = $request['name'];
            $author->surname = $request['surname'];
            $author->patronymic = isset($request['patronymic']) ? $request['patronymic'] : null;
            $author->save();
            unset($author);
            $result = Author::find($request['id']);
        } else {
            $result = $validate;
        }
        return $result;
    }

    public function delete(DeleteAuthorRequest $request){

        $validate = $request->validated();
        if (!isset($validate['errors'])) {
            $author = Author::find($request['id']);
            $author->delete();
            $result = $author;
        } else {
            $result = $validate;
        }
        return $result;
    }
}
