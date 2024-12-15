<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\namespaces;
use App\Models\Pods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;
use function Pest\Laravel\json;

class UserProjectController extends Controller
{

    public function index(Request $request)
    {

        return response()->json([
            'parameters'=> Pods::where('slug' , $request['slug'])->first()->parameters
        ]);
    }
    public function create(Request $request)
    {

        return Inertia::render('Dashboard/User/Projects' , [
            'bannerTitle' => 'پروژه‌ها',
            'bannerBody' => 'در این قسمت می‌توانید پروژه‌ی جدید تعریف کنید',
            'projects' => auth()->user()->projects()->select('id', 'name', 'slug', 'updated_at')->get()
        ]);

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);
        $slug = $this->generateUniqueSlug();
        $namespace = namespaces::create([
            'user_id' => auth()->id(),
            'name' => $validatedData['name'],
            'slug' => $slug,
        ]);
        // Create the namespace in Kubernetes
        $this->createKubernetesNamespace($namespace->slug);

         return redirect()->back()->with('success', 'project Saved successfully!');
    }
    private function generateUniqueSlug()
    {
        $length = 10; // You can adjust this length as needed
        do {
            $slug = $this->randomLowercaseString(10);
        } while (namespaces::where('slug', $slug)->exists());

        return $slug;
    }


    function randomLowercaseString($length = 32)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
    private function createKubernetesNamespace($slug)
    {
        $response = Http::post('localhost:8080/create-namespace', [
            'Name' => $slug
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to create Kubernetes namespace: ' . $response->body());
        }
    }

    public function destroy(Request $request , $id)
    {
        $res = namespaces::where("id" ,"=" ,$id)->first();
        $this->deleteKubernetesNamespace($res->slug);
        $res->delete();
        if ($res){
            redirect()->back()->with('success', 'project deleted successfully!');
        }
    }

    private function deleteKubernetesNamespace($slug)
    {
        $response = Http::post('localhost:8080/delete-namespace', [
            'Name' => $slug
        ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to create Kubernetes namespace: ' . $response->body());
        }
    }
}
