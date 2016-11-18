<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Event;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class CommentController extends Controller
{
    /**
     * Mostrar los comentarios para una tarea
     *
     * @param Request $request
     * @param Event $event
     * @return mixed
     */
    public function getComment(Request $request, Event $event)
    {

        return view('tasks.events.show-comment',compact('event'));
    }

     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment=Comments::findOrFail($id);
        
        return view('tasks.events.edit-comment',compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment=Comments::findOrFail($id);
        $comment->update($request->all());
        
        Session::flash('message','Se edito el comentario correctamente');
        return redirect()->route('user.profile.tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment=Comments::findOrFail($id);
        $comment->delete();
        Session::flash('message_danger','Se eliminó el comentario');
        return redirect()->route('user.profile.tasks');
    }
}
