<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use BeyondCode\LaravelWebSockets\Apps\AppProvider;
use BeyondCode\LaravelWebSockets\Dashboard\DashboardLogger;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Http\Request;
use Nette\Utils\DateTime;
use Pusher\Pusher;
use Pusher\PusherException;

class SocketController extends Controller
{

   public function chat (AppProvider $appProvider) {
        return view('chat', [
            "port" => "6001",
            "host" => "127.0.0.1",
            "authEndpoint" => "/api/sockets/connect",
            "logChannel" => DashboardLogger::LOG_CHANNEL_PREFIX,
            "apps" => $appProvider->all()
        ]);
    }

    /**
     * @throws \Exception
     */
    public function send(Request $request) {
        $message = $request->input("message", null);
        $name = $request->input("name", "Anonymous");
        $time = (new DateTime(now()))->format(DateTime::ATOM);
        if ($name == null) {
            $name = "Anonymous";
        }
        SendMessage::dispatch($name, $message, $time);
    }


    /**
     * @throws PusherException
     */
    public function connect(Request $request)
    {


        $broadcaster = new PusherBroadcaster(
            new Pusher(
                env('PUSHER_APP_KEY'),

                env('PUSHER_APP_SECRET'),

                env('PUSHER_APP_ID'),
                []
            ));

        return $broadcaster->validAuthenticationResponse($request, []);
    }
}
