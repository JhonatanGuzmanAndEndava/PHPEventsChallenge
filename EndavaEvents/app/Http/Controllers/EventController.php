<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('user_id','=',Auth::id())->get()->sortBy('created_at');
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check())
        {
            $event = new Event();
            $event->name = $request->get('name');
            $event->user_id = Auth::id();
            $event->category = $request->get('category');
            $event->place = $request->get('place');
            $event->address = $request->get('address');

            $event->start_date = $request->get('start_date');
            $event->end_date = $request->get('end_date');

            $event->is_virtual = $request->get('is_virtual') == 1 ? 1 : 0;

            $event->save();
            return redirect()->route('events.index')
                ->with('success','Evento agregado exitosamente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if($event->user_id == Auth::id() && Auth::check()) {
            return view('events.show',compact('event'));
        }
        else {
            return redirect()->route('events.index')
                ->with('fail','No puedes ver ese evento');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
        if($event->user_id == Auth::id() && Auth::check()) {
            return view('events.edit',compact('event'));
        }
        else {
            return redirect()->route('events.index')
                ->with('fail','No puedes editar ese evento');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
        request()->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        if($event->user_id == Auth::id() && Auth::check()) {
            $event->is_virtual = $request->get('is_virtual') == 1 ? 1:0;
            $event->update($request->all());

            return redirect()->route('events.index')
                ->with('success','Evento actualizado correctamente');
        }
        else {
            return redirect()->route('events.index')
                ->with('fail','No puedes actualizar ese evento');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
        if($event->user_id == Auth::id() && Auth::check()) {
            $event->delete();
            return redirect()->route('events.index')
                ->with('success','Evento eliminado correctamente');
        }
        else {
            return redirect()->route('events.index')
                ->with('fail','No puedes eliminar ese evento');
        }
    }
}
