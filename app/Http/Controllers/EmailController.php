<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use App\Models\User;
use App\Models\Email as EmailModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function create()
    {
        $users = User::query()->select('user_id', 'name', 'email')->get();
        return view('criar-email', compact('users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'assunto' => 'required|string|max:45',
            'mensagem' => 'required|string',
        ]);

        try {
            $receiver = User::findOrFail($request->user_id);
            $sender = Auth::user();

            Mail::to($receiver->email)->send(
                new Email($receiver, $request->assunto, $request->mensagem)
            );

            EmailModel::create([
                'subject' => $request->assunto,
                'content' => $request->mensagem,
                'date' => Carbon::now(),
                'receiver_id' => $receiver->user_id,
                'sender_id' => $sender->user_id,
                'sender_function_id' => $sender->function_id,
            ]);

            return back()->with('success', 'E-mail enviado e registrado com sucesso para ' . $receiver->name);

        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro: ' . $e->getMessage());
        }
    }
}
