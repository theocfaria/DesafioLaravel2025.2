<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagSeguroConnectController extends Controller
{
    public function connect()
    {
        $appId = env('PAGSEGURO_APP_ID');
        $redirectUrl = route('pagseguro.callback');
        $permissions = 'CREATE_CHECKOUTS';

        $url = "https://sandbox.pagseguro.uol.com.br/v2/authorization/request.jhtml?appId={$appId}&permissions={$permissions}&redirectURL={$redirectUrl}";

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $authorizationCode = $request->input('notificationCode');

        if (!$authorizationCode) {
            return redirect('/dashboard')->with('error', 'A autorização com o PagSeguro falhou.');
        }

        $user = Auth::user();
        $user->pagseguro_authorization_code = $authorizationCode;
        $user->save();

        return redirect('/dashboard')->with('success', 'Sua conta PagSeguro foi conectada com sucesso!');
    }
}