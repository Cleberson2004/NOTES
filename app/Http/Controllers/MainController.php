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
                'text_title.min' => 'O titulo da nota deve ter pelo menos é :min caracteres',
                'text_title.max' => 'O titulo da nota deve ter no máximo é :max caracteres',
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
        $id = Operations::decryptId($id);

        //load note
        $note = Note::find($id);
        // show edit note view
        return view('edit_note', ['note'=>$note]);
    }
    public function editNoteSubmit(Request $request)
    {
        
        //validade request
        $request->validate(
            //rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            //error mensages
            [
                'text_title.required' => 'O titulo da nota é obrigatório',
                'text_title.min' => 'O titulo da nota deve ter pelo menos é :min caracteres',
                'text_title.max' => 'O titulo da nota deve ter no máximo é :max caracteres',
                'text_note.required' => 'O texto da nota é obrigatório',
                'text_note.min' => 'A nota deve ter pelo menos é :min caracteres',
                'text_note.max' => 'A nota deve ter pelo menos é :max caracteres',
            ]
        );

        //check if note_id exist
        if($request->note_id == null){
            return redirect()->route('home');
        }
        //decrypt note_id
        $id = Operations::decryptId($request->note_id);

        //load note
        $note = Note::find($id);

        //update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        //redirect to home
        return redirect()->route('home');
    }
    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        //load note
        $note = Note::find($id);
        //show delete message confirmation
        return view('delete_note',['note' => $note]);
    }
    public function deleteNoteConfirm($id)
    {
        //check if the id is encrypted
        $id = Operations::decryptId($id);

        //load note
        $note = Note::find($id);

        //1. hard delete
        $note->delete();

        //2. soft delete

        //redirect to home
        return redirect()->route('home');
    }
};
