<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'capacity' => 'required|integer',
            'base_price' => 'required|numeric',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index');
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'capacity' => 'required|integer',
            'base_price' => 'required|numeric',
            'status' => 'required'
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index');
    }
}
