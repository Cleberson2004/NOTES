<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MainController extends Controller
{
    public function index()
    {
       //load user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

       //load home view
       return view('home', ['notes'=>$notes]);
    }

    public function newNote()
    {
       return view('new_note');
    }
    public function newNoteSubmit(Request $request){
        //validate request
        $request->validate(
            //rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            //error mensages
            [
                'text_title.required' => 'O titulo da nota é obrigatório',
                'text_note.required' => 'O texto da nota é obrigatório',
                'text_note.min' => 'A nota deve ter pelo menos é :min caracteres',
                'text_note.max' => 'A nota deve ter pelo menos é :max caracteres',
            ],
        );
        //get user id
        $id = session('user.id');

        //create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //redirect to home
        return redirect()->route('home');
    }


    public function editNote($id)
    {
        //$id = $this->decryptId($id);
        $id = Operations::decryptId($id);

        //load note
        $note = Note::find($id);
        // show edit note view
        return view('edit_note', ['note'=>$note]);
    }
    public function editNoteSubmit(Request $request)
    {
        //validade request

        //decrypt note_id

        //load note

        //update note

        //redirect to home
    }
    public function deleteNote($id)
    {
        //$id = $this->decryptId($id);
        $id = Operations::decryptId($id);
        echo 'I am deleting the note with id = $id';
    }
};
