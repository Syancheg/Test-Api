<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddJournalRequest;
use App\Http\Requests\UpdateJournalRequest;
use App\Http\Requests\DeleteJournalRequest;
use App\Models\Journal;
use App\Models\JournalToAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class JournalController extends Controller
{
    private $dirImage = 'storage/img/';

    public function index(Request $request){

        $page = $request->input('page') ? $request->input('page') : 1;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $skip = ($page - 1) * $perPage;
        $dirImage = 'storage/img/';
        $journals = Journal::skip($skip)
            ->take($perPage)
            ->get();
        for ($i = 0; $i < count($journals); $i++){
            $journals[$i]['authors'] = $this->getAuthors($journals[$i]['id']);
            $journals[$i]['image'] = asset($dirImage . $journals[$i]['image']);
        }
        return $journals;
    }

    public function add(AddJournalRequest $request){

        $validate = $request->validated();
        if(!isset($validate['errors'])){
            $authors = $request['authors'];
            if (Cache::has('fileName')) {
                $image = Cache::get('fileName');
                Cache::forget('fileName');
            } else {
                $image = basename($request['image']);
            }
            $journal = Journal::create(['name' => $request['name'], 'title' => $request['title'], 'image' => $image, 'release_date' => $request['release_date']]);
            foreach ($authors as $author){
                JournalToAuthor::create(['author_id' => $author['id'], 'journal_id' => $journal['id']]);
            }
            $journal['authors'] = $this->getAuthors($journal['id']);
            $journal['image'] = asset($this->dirImage . $journal['image']);
            $result = $journal;
        } else {
            $result  = $validate;
        }
        return $result;
    }

    public function update(UpdateJournalRequest $request){

        $validate = $request->validated();
        if(!isset($validate['errors'])){
            $journal = Journal::find($request['id']);
            $journal->name = $request['name'];
            $journal->title = $request['title'];
            if (Cache::has('fileName')) {
                $journal->image = Cache::get('fileName');
                Cache::forget('fileName');
            } else {
                $journal->image = basename($request['image']);
            }
            $journal->release_date = $request['release_date'];
            $journal->save();
            $authors = $request['authors'];
            JournalToAuthor::where('journal_id', $journal['id'])->delete();
            foreach ($authors as $author){
                JournalToAuthor::create(['author_id' => $author['id'], 'journal_id' => $journal['id']]);
            }
            unset($journal);
            $journal = Journal::find($request['id']);
            $journal['authors']= $this->getAuthors($request['id']);
            $journal['image'] = asset($this->dirImage . $journal['image']);
            $result = $journal;
        }else {
            $result  = $validate;
        }
        return $result;
    }

    public function delete(DeleteJournalRequest $request){

        $validate = $request->validated();
        if (!isset($validate['errors'])) {
            $journal = Journal::find($request['id']);
            $journal->delete();
            $result = $journal;
        } else {
            $result = $validate;
        }
        return $result;
    }

    private function getAuthors($journalId){

        return $authors = JournalToAuthor::join('authors', 'authors.id', '=', 'journal_to_authors.author_id')
            ->select('authors.id', 'authors.name', 'authors.surname')
            ->where('journal_to_authors.journal_id', $journalId)
            ->get();

    }
}
