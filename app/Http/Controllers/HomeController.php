<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;
use App\User;
use App\Admin;
use App\Teacher;
use App\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Validate the user.
     *
     * @param  Request  $request
     * @return Response $user
     */
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::where('email',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                Session::put('school_id', $user->school_id);
                return redirect('/dashboard')
                        ->with('user',$user);
            }else{
                return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
            }
        }else{
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
    }

    /**
     * Register the school.
     *
     * @param  Request  $request
     * @return Response $user
     */
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'admin_name' => 'required',
            'admin_email' => 'required',
            'admin_password' => 'required',
            'designation' =>'required'
        ]);
        if ($validator->fails()) {
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::where('email',$request->admin_email)->first();
        if(!$user){
            $school = new School;
            $school->name=$request->name;
            $school->phone=$request->phone;
            $school->email=$request->email;
            if($school->save()){
                $admin_password = Hash::make($request->admin_password);
                $user = new User;
                $user->name=$request->admin_name;
                $user->email=$request->admin_email;
                $user->password=$admin_password;
                $user->school_id=$school->id;
                if($user->save()){
                    $admin = new Admin;
                    $admin->user_id=$user->id;
                    $admin->name=$request->admin_name;
                    $admin->designation=$request->designation;
                    $admin->school_id=$school->id;
                    if($admin->save()){
                        Session::put('school_id', $school->id);
                        return redirect('/dashboard');
                    }else{
                        return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
                    }
                }else{
                    return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
                }
            }else{
                return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
            }
        }else{
            return redirect('/login')
                        ->withErrors($validator)
                        ->withInput();
        }
    }
    /**
     * Load the dashboard.
     *
     * @param  Request  $request
     * @return Response $response
     */
    public function dashboard(Request $request){
        return view('dashboard');
    }
    /**
     * Load the Teacher layout.
     *
     * @param  Request  $request
     * @return Response $response
     */
    public function teacher(Request $request){
        return view('teacher');
    }
    /**
     * Adding Teacher.
     *
     * @param  Request  $request
     * @return Response $teacher
     */
    public function addTeacher(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'designation' =>'required'
        ]);
        if ($validator->fails()) {
            return redirect('/addTeacher')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = Teacher::where('email',$request->email)->first();
        if(!$user){
            $teacher = new Teacher;
            $teacher->name=$request->name;
            $teacher->phone=$request->phone;
            $teacher->email=$request->email;
            $teacher->designation=$request->designation;
            $teacher->school_id=Session::get('school_id');
            if($teacher->save()){
                return redirect('/dashboard');
            }else{
                return redirect('/addTeacher')
                        ->withErrors($validator)
                        ->withInput();
            }
        }else{
            return redirect('/teacher')
                        ->withErrors($validator)
                        ->withInput();
        }
    }
    /**
     * Load the Student layout with Teacher data.
     *
     * @param  Request  $request
     * @return Response $response
     */
    public function student(Request $request){
        $teacher = Teacher::all();
        return view('student')->with('teachers',$teacher);
    }
    /**
     * Adding Student.
     *
     * @param  Request  $request
     * @return Response $student
     */
    public function addStudent(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'class' => 'required',
            'gender' => 'required',
            'teacher' =>'required'
        ]);
        if ($validator->fails()) {
            return redirect('/student')
                        ->withErrors($validator)
                        ->withInput();
        }
        $student = new Student;
        $student->name=$request->name;
        $student->class=$request->class;
        $student->gender=$request->gender;
        $student->teacher_id=$request->teacher;
        $student->school_id=Session::get('school_id');
        if($student->save()){
            return redirect('/dashboard');
        }else{
            return redirect('/student')
                    ->withErrors($validator)
                    ->withInput();
        }
        
    }
}
