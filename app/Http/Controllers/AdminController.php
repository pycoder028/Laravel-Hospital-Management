<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Doctor;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function addview(){

        return view('admin.pages.add_doctor');
    }   // End method here

    public function upload(Request $request){

        $doctor = new doctor;

        $image = $request->file;

        $imagename = time().'.'.$image->getClientOriginalExtension();

        $request->file->move('doctorimage', $imagename);

        $doctor->image = $imagename;

        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;

        $doctor->save();

        return redirect()->back()->with('message','Doctor Added Successfully');
        
    }   // End method here

    public function showappointments(){

        $data = appointment::all();

        return view('admin.pages.showappointment',compact('data'));
    }   // End method here

    public function approved($id){

        $data = appointment::findOrFail($id);
        $data->status = 'approved';
        $data->save();
        return redirect()->back();
    }   // End method here

    public function canceled($id){

        $data = appointment::findOrFail($id);
        $data->status = 'canceled';
        $data->save();
        return redirect()->back();
    }   // End method here

    public function showdoctor(){

        $data = doctor::all();

        return view('admin.pages.showdoctor',compact('data'));
    }   // End method here

    public function deletedoctor($id){

        $data = doctor::findOrFail($id);

        $data->delete();

        return redirect()->back();

    }   // End method here

    public function updatedoctor($id){

        $data = doctor::findOrFail($id);

        return view('admin.pages.updatedoctor', compact('data'));

    }   // End method here

    public function editdoctor(Request $request,$id){

        $doctor = doctor::findOrFail($id);

        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;

        /* update image */
        $image = $request->file;

        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();

            $request->file->move('doctorimage',$imagename);
            $doctor->image = $imagename;
        }

        $doctor->save();

        return redirect()->back()->with('message', 'Doctor Details Updated Successfully!');

    }   // End method here


}


