<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
use App\Models\Notes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotesController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'notes' => 'required'
        ]);

        $user = User::find($request->user_id);

        if( $user )
        {
            $request->merge(['note_date' => date('Y-m-d')]);
            $note = $user->notes()->insert($request->except(['_token', '_method']));

            return response()->json([
                'msg' => 'Note added',
                'value' => [
                    'date' => $request->note_date,
                    'notes' => $request->notes
                ],
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]); 
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
        $this->validate($request, [
            'notes' => 'required'
        ]);

        $note = Notes::find($id);

        if( $note )
        {
            $note->update($request->only(['notes']));

            return response()->json([
                'msg' => $request->notes,
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Notes::find($id);

        if( $note ) {
            $note->delete();
            
            return redirect()->back();
        }
    }
}
