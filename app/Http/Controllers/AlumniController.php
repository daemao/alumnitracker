<?php

namespace App\Http\Controllers;
use App\AlumniInfo;
use App\User;
use Illuminate\Http\Request;
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
        return User::with(["avatar","alumni_info.program","alumni_info.department","photos"])->find($id);
    }
    public function createAlumniInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'cumulative_gpa' => 'required',
            'university_id' => 'required',
            'id_in_university' => 'required',
            'graduate_year' => 'required',
            'program_id' => 'required',
            'department_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),433);
        }else{
            AlumniInfo::create($request->all());
        }
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
        $sheet->setCellValue('F1','GPA');
        $row = 2;
        foreach ($users as $user){
            $sheet->setCellValue('A'.$row, $user->first_name);
            $sheet->setCellValue('B'.$row, $user->last_name);
            $sheet->setCellValue('C'.$row,$user->email);
            if($user->alumni_info){
                $sheet->setCellValue('D'.$row,$user->alumni_info[0]->program->name);
                $sheet->setCellValue('E'.$row,$user->alumni_info[0]->department->name);
                $sheet->setCellValue('F'.$row,$user->alumni_info[0]->cumulative_gpa);
            }
            $row = $row+1;
        }
        $writer = new Xlsx($spreadsheet);
        $hash = date('mdYHis').uniqid();
        $writer->save('sheets/' . $hash . '.xlsx');
        return url('/') . '/sheets/' . $hash . '.xlsx';
    }

}
