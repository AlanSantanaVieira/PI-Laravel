namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SenhaController extends Controller
{
    // Verifica se o email existe
    public function verificaEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = DB::table('cadastro')->where('email', $request->email)->first();

        if ($user) {
            return redirect()->route('form-nova-senha', ['email' => $request->email]);
        }

        return back()->withErrors(['email' => 'E-mail não encontrado.']);
    }

    // Mostra o formulário de nova senha
    public function formNovaSenha($email)
    {
        return view('alterar-senha', compact('email'));
    }

    // Altera a senha
    public function alterar(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'nova_senha' => 'required|min:3|confirmed',
        ]);

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->nova_senha),
            ]);

        return redirect('/log')->with('sucesso', 'Senha alterada com sucesso!');
    }
}
