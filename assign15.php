@@ -0,0 +1,320 @@
<?php

// Task -1 :
// Answer :


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationFormRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true to allow the validation to occur.
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }
}

// Now, let's use the RegistrationFormRequest rule controller to validate the registration form input.


namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;

class RegistrationController extends Controller
{
    public function store(RegistrationFormRequest $request)
    {

        $user = User::create($request->validated());

        return response()->json(['message' => 'Registration successful'], 200);
    }
}


// Task -2 :
// Answer :

// routes/web.php file

Route::get('/home', function () {
    return redirect('/dashboard');
});






// Task -3 :
// Answer :



// php artisan make:middleware LogRequest (php artisan command for commandline)


<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequest
{
    public function handle($request, Closure $next)
    {
        Log::info('Request Method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());

        return $next($request);
    }
}



// Task -4 :
// Answer :

'auth' => \App\Http\Middleware\AuthMiddleware::class,


// php artisan make:middleware AuthMiddleware (php artisan command for commandline)

<?php

namespace App\Http\Middleware;

use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            // User is not authenticated, redirect to login or show an unauthorized message
            return redirect('/login');
        }

        return $next($request);
    }
}



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        // Route logic for profile
    });

    Route::get('/settings', function () {
        // Route logic for settings
    });
});


// Task -5 :
// Answer :


// php artisan make:controller ProductController --resource  (php artisan command for commandline)


namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:2',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Product::create($validatedData);

        return redirect('/products')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:2',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect('/products')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/products')->with('success', 'Product deleted successfully.');
    }
}



// Task -6 :
// Answer :

// php artisan make:controller ContactController --invokable (php artisan command for commandline)



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Send an email with the submitted data
        Mail::raw($validatedData['message'], function ($message) use ($validatedData) {
            $message->to('your-email@example.com')
                ->subject('New Contact Form Submission')
                ->from($validatedData['email'], $validatedData['name']);
        });

        return redirect('/')->with('success', 'Thank you for your message!');
    }
}



// Task -7 :
// Answer :


// php artisan make:controller PostController --resource  (php artisan command for commandline)


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Logic to fetch all posts
    }

    public function create()
    {
        // Logic to show create form
    }

    public function store(Request $request)
    {
        // Logic to store a new post
    }

    public function show($id)
    {
        // Logic to fetch a specific post by $id
    }

    public function edit($id)
    {
        // Logic to show edit form for a specific post
    }


    public function update(Request $request, $id)
    {
        // Logic to update a specific post
    }

    public function destroy($id)
    {
        // Logic to delete a specific post
    }
}


// routes/web.php file

Route::resource('posts', 'App\Http\Controllers\PostController');




// Task -8 :
// Answer :


// welcome.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <nav>
        <!-- Your navigation bar code here -->
    </nav>

    <section>
        <h1>Welcome to Laravel!</h1>
    </section>
</body>
</html>





?>