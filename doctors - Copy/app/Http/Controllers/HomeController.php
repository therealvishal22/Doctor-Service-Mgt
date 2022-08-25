<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Services;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index(Request $request)
    {
        $md = DB::table('services')->get();
        if (auth()->user()->is_admin == '1') 
        {
            $filter = $request->filter;   
            //print_r($filter);die();
            if (empty($filter)) {
                $users = User::with('services')->where('is_admin', '0')->orwhere('approve', 'F')->sortable()->paginate(5);
            } else {
                
                $users = User::with('services')->whereHas('services', function ($admin) use ($filter) {
                $admin->where('service_id', $filter);
                })
                //->get();
              //echo"<pre>" ; print_r($users);die();
                 ->sortable()->paginate(3);
                 //echo"<pre>" ; print_r($filter);die();
            } 
            return view('admin.index', compact(['users', 'md','filter']))->with('i', (request()->input('page', 1) - 1) * 5); 

        }
        elseif(auth()->user()->is_admin == '0')
        {
            if (auth()->user()->approve == 'F' || auth()->user()->approve == 'E') 
            {   

                $users = User::with('services')->where('id', auth()->user()->id)
                ->where('status','Active')->sortable()->paginate(5);    
                return view('admin.index', compact('users', 'md'));
            }
            else 
            {
                $users = User::where('is_admin','0')->where('status','Active')->where('approve','T')->sortable()->paginate(5);
                return view('admin.index', compact('users','md'));
            }
        }
       
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->is_admin == 1) {
            return view('admin.create');
        } else {
            return back()->with('error', 'You Are not Administrator');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2 | max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required | min:5',
            'status' => 'required',

        [
            'name.required' => 'User Name is Required',
            'name.min' => 'Minimum 2 charachers Require!!',
            'name.max' => 'Miximum 20 charachers Require!!',
            'email.required' => 'Email is Required',
            'email.unique' => 'Email is already Taken,Please Add Something New!',
            'password.required' => 'Password is Required',
            'password.min' => 'Minimum 5 charachers Required!!',
        ],
        ]);

        
        // $user->create($request->all());
            
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->save();
        $password = Hash::make('password');        
     
        return redirect()->route('admin.index')
                        ->with('success','User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user ,$id)
    {
        
        $services = Services::all();
        $user = User::find($id);     

        $user_services = $user->services->pluck('id')->toArray();

        return view('admin.edit',compact('user','id','user_services','services'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user,$id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'age' => 'required',
        ]);
       
    $user = User::find($id);
    {  
        if(!empty($request->image))
        {

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('./public/images/'), $imageName);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->age = $request->age;
            $user['image'] = $imageName;
            $user['approve']= 'F';
        
            $user->update();
          
            $s_u = $request->services;
            $user->services()->sync($s_u);

            return redirect()->route('admin.index') ->with('success','Profile Updated Successfully');
        }
        else
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->age = $request->age;
            $user['approve']= 'F';

            $user->update();
            $s_u = $request->services;
            $user->services()->sync($s_u);
            return redirect('admin') ->with('success','Profile Updated Successfully');
        }
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user,$id)
    {
        User::find($id)->delete();
        return back()->with('success','User deleted successfully');
     
    }

    public function approve($id)
    {
        User::find($id)->update(['approve' => 'T']);
        return back()->with('success', 'Request Approved Successfully.');
    }

    public function export() 
    {
        return Excel::download(new UserExport, 'UserData.xlsx');
    }

    public function adminHome()
    {
        return view('adminHome');
    }

    public function vishal()
    {
        return view('home');
    }

    public function active($id)
    {
        $test = User::find($id)->update(['status' => 'Active']);
        return back()->with('success', 'Request Activated');
        
    }
    public function inactive($id)
    {
        $test = User::find($id)->update(['status' => 'Inactive']);
        return back()->with('success', 'Request Deactivated');
    }

}
