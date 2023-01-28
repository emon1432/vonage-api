<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Mockery\Matcher\AnyArgs;
use OpenTok\OpenTok;
use Symfony\Component\Console\Output\AnsiColorMode;

class RoomController extends Controller
{
    //
    protected $key;
    protected $opentok;

    public function __construct(OpenTok $opentok)
    {
        $this->key = Config::get('OPENTOK_KEY');
        $this->opentok = $opentok;
    }

    public function joinRoom()
    {

        $room = Room::where('name', 'demo-room')->first();

        if (!$room) {
            $session = $this->opentok->createSession();
            $room = new Room([
                'name' => 'demo-room',
                'session_id' => $session->getSessionId(),
            ]);
            $room->save();
        }

        return view('room', [
            'apiKey' => $this->key,
            'sessionId' => $room->session_id,
            'token' => $this->opentok->generateToken($room->session_id),
        ]);
    }
}
