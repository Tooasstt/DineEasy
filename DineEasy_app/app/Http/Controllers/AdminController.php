namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Replace 'admins' with your guard/table if you have a custom admin login
        if (Auth::attempt($credentials)) {
            return redirect()->route('kiosk.dashboard'); // ✅ redirect to kiosk
        }

        return back()->with('error', 'Invalid email or password.');
    }
}
