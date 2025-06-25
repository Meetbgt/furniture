<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Home_header_model;
class Home_header extends Controller
{
    public function index()
    {   
        return view("admin/home_header");
    }
    public function home_header_insert(Request $request)
    {
        $heading = $request->input("heading");
        $description = $request->input("description");
        $contact_us_button = $request->input("contact_us_button") ? 1 : 0;
        $image = $request->file("image");
        if ($request->hasFile("image")) {
            $extension = $image->getClientOriginalExtension();
            $name = md5_file($request->file("image"));
            $fileName = $name . "." . $extension;
            $image->move(Public_path("upload/home_header"), $fileName);
            $image = $fileName;
        } else {
            return json_encode(["success" => false, "message" => "Image is not Uploaded"]);
        }
        if ($request["id"] != null) {
            $insert = Home_header_model::where("home_header_id", $request["id"])->update([
                'heading' => $heading,
                'description' => $description,
                'contact_us_button' => $contact_us_button,
                'image' => $image,
            ]);
            return json_encode(["success" => true, "message" => "Update Success..."]);
        } else {
            $insert = Home_header_model::create([
                'heading' => $heading,
                'description' => $description,
                'contact_us_button' => $contact_us_button,
                'image' => $image,
            ]);
            return json_encode(["success" => true, "message" => "Register Success..."]);
        }
        if ($insert) {
            return json_encode(["success" => true, "message" => "Register Success Redirecting..."]);
        } else {
            return json_encode(["success" => false, "message" => "Register Failed"]);
        }
    }
    // DataTable Controller
    public function home_header_list(Request $request)
    {
        $query = Home_header_model::orderBy("home_header_id", "desc");
        $totalData = $query->count();
        $limit = $request->input("length");
        $start = $request->input("start");
        $search = $request->input("search.value");
        if (!empty($search)) {
            $query->where("heading", "like", "%" . $search . "%");
            $query->where("description", "like", "%" . $search . "%");
            $query->where("contact_us_button", "like", "%" . $search . "%");
            $query->where("image", "like", "%" . $search . "%");
        }
        $records = $query->offset($start)->limit($limit)->get();
        $data = [];
        foreach ($records as $row) {
            $data[] = [
                "heading" => $row->heading,
                "description" => $row->description,
                "contact_us_button" => $row->contact_us_button,
                "image" => $row->image,
                "Action" => '<span><button type="button" class="badge badge-info home_header_edit" data-id="' . $row->home_header_id . '"><i class="fa-solid fa-edit"></i></a>' . '<button type="button" ' . $row->home_header_id . '" class="badge badge-info login_delete" data-id="' . $row->home_header_id . '"><i class="fa-solid fa-trash"></i></a></span>'
            ];
        }
        $json_data = [
            "draw" => intval($request->input("draw")),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data,
        ];
        return response()->json($json_data);
    }
    public function home_header_getdata(Request $request)
    {
        $id = $request->post("id");
        $data = Home_header_model::where("home_header_id", $id)->first();
        if ($data) {
            return response()->json([
                "success" => true,
                "message" => "Data Fetch Success.",
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Data Fetch Error."
            ]);
        }
    }
    public function home_header_delete(Request $request)
    {
        $id = $request->post("id");
        $data = Home_header_model::where("home_header_id", $id)->delete();
        if ($data) {
            return response()->json();
        }
    }

}