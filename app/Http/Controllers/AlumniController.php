<?php

namespace App\Http\Controllers;
use App\Achievement;
use App\AlumniInfo;
use App\Company;
use App\Country;
use App\Department;
use App\University;
use App\User;
use App\WorkExperience;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class AlumniController extends Controller{

    public function items(){
        return User::where("role_id",2)->with(["alumni_info"])->filter(Input::all())->paginate(20);
    }
    public function item(Request $request,$id){
        return User::with(["avatar","alumni_info.program","followers","followings","achievements","alumni_info.department","current_university.university","current_company.company","work_experience.company","alumni_info.university.country","photos"])->find($id);
    }

    public function getFollowers($id){
        return User::whereHas("followers",function ($q) use($id){
           $q->where("user_id",$id);
        })->get();
    }
    public function getFollowings($id){
        return User::whereHas("followers",function ($q) use($id){
            $q->where("friend_id",$id);
        })->get();
    }

    public function createWorkExperience(Request $request){
        if(!$request->get("company_id")){
            return response()->json(["company_id"=>"Company is required"],422);
        }
        if($request->get("company_id")=="other"){
            $new_company = Company::whereTranslation("name",$request->get("new_company"))->first();
            $new_company = $new_company? $new_company:new Company();
            $new_company->translateOrNew($request->user()->locale)->name = $request->get("new_company");
            $new_company->save();
        }
        $company = $request->get("company_id")=="other"?$new_company:Company::find($request->get("company_id"));
        $we=WorkExperience::create();
        $we->user_id = $request->get("user_id")?$request->get("user_id"):$request->user()->id;
        $we->company_id = $company->id;
        $we->position = $request->get("position");
        $we->save();
        User::where("id",$we->user_id)->update(["status_id"=>1,"current_university_id"=>$we->id]);
    }
    public function createAlumniInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'university_id' => 'required',
            'program_id' => 'required',
            'department_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),433);
        }else{
            $info = $request->all();
            if($request->get("university_id")=='other'){
                $university = $request->get("new_university");
                if($university["country_id"]=="other"){
                    $temp = Country::whereTranslation("name",$request->get("new_country"))->first();
                    $new_country = $temp? $temp:Country::create();
                    $country = $request->get("new_country");
                    $new_country->translateOrNew($request->user()->locale)->name=$country["name"];
                    $new_country->save();
                }
                $temp_c = University::whereTranslation("name",$request->get("new_university"))->first();
                $new_university = $temp_c? $temp_c:new University();
                $new_university->country_id = $university["country_id"]=="other"?$new_country->id:$university["country_id"];
                $new_university->translateOrNew($request->user()->locale)->name=$university["name"];
                $new_university->save();
                $info["university_id"]=$new_university->id;
            }

            if($request->get("department_id") =='other'){
                $department = $request->get("new_department");
                $new_department = Department::create();
                $new_department->translateOrnew($request->user()->locale)->name = $department;
                $new_department->save();
                $info["department_id"]=$new_department->id;
            }
            $alumni_info=AlumniInfo::create($info);
            Log::info($alumni_info->toArray());
            User::where("id",$alumni_info->user_id)->update(["status_id"=>2,"current_university_id"=>$alumni_info->id]);
        }
    }
    public function createAchivement(Request $request){
       if(!$request->get("description")){
           return response()->json(["description"=>"achievement is not provided"],422);
       }
       $achivement = $request->get("id")?Achievement::find($request->get("id")):new Achievement();
       $achivement->description = $request->get("description");
       $achivement->user_id = $request->get("user_id")?$request->get("user_id"):$request->user()->id;
       $achivement->time = Carbon::now();
       $achivement->save();
    }
    public function exportAlumniSpreadsheet(Request $request){
        $style_default = [
            'font' => [
                'size' => 12
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];
        $style_heading = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'font' => ['bold' => true],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'd5a6db']
            ]
        ];

        $is_all_alumni = $request->get("all_alumni");
        $alumni_list  = $request->get("alumni_list")? $request->get("alumni_list"):[];
        $users = $is_all_alumni? User::where("role_id",2):User::whereIn("id",$alumni_list);
        $users= $users->with(["alumni_info"=>function($q){
            $q->with(["department","program"]);
        }])->get();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->applyFromArray($style_default);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')->applyFromArray($style_heading);
        $sheet->getStyle('B1')->applyFromArray($style_heading);
        $sheet->getStyle('B1')->applyFromArray($style_heading);//todo
        $sheet->getStyle('C1')->applyFromArray($style_heading);
        $sheet->getStyle('D1')->applyFromArray($style_heading);
        $sheet->getStyle('E1')->applyFromArray($style_heading);
        $sheet->getStyle('F1')->applyFromArray($style_heading);
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(27);
        $sheet->getColumnDimension('F')->setWidth(7);
        $sheet->setCellValue('A1', 'First name');
        $sheet->setCellValue('B1', 'Last name');
        $sheet->setCellValue('C1','email');
        $sheet->setCellValue('D1','program');
        $sheet->setCellValue('E1','department');
        $row = 2;
        foreach ($users as $user){
            $sheet->setCellValue('A'.$row, $user->first_name);
            $sheet->setCellValue('B'.$row, $user->last_name);
            $sheet->setCellValue('C'.$row,$user->email);
            if($user->alumni_info && isset($user->alumni_info[0])){
                $sheet->setCellValue('D'.$row,$user->alumni_info[0]->program->name);
                $sheet->setCellValue('E'.$row,$user->alumni_info[0]->department->name);
            }
            $row = $row+1;
        }
        $writer = new Xlsx($spreadsheet);
        $hash = date('mdYHis').uniqid();
        $writer->save('sheets/' . $hash . '.xlsx');
        return url('/') . '/sheets/' . $hash . '.xlsx';
    }

    public function getAvailableFollowers(Request $request){
        return User::where("role_id",2)->whereNot("id",$request->user()->id)->filter(Input::all())->get();
    }

    public function startFollow(Request $request){
        $user_id = $request->get("user_id");
        $user_ids = $request->get("users");
        if($user_ids){
                $requests=[];
                foreach ($user_ids as $id){
                    $requests[$id] = ['friend_id' => $id,"accepted"=>0];
                }
            }
            $request->user()->followings()->attach($requests);
        if($user_id)
            $request->user()->followings()->attach(array($user_id));
    }
}
