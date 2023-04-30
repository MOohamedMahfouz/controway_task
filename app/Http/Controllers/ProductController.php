<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends Controller
{



    public function importProductsWithMapping(Request $request)
    {
        $file_path = $request->session()->get('file_path');
        $absolute_path = Storage::path($file_path);
        $spreadsheet = IOFactory::load($absolute_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        // Get the column mappings from the request
        $mappings = $request->input('mappings');

        // $mappings = array_flip($mappings);

        $map = [];

        $isFirstElement = 1;
        // Loop through the rows
        foreach ($worksheet->getRowIterator() as $row) {
            // Get the cell values
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $data = [];

            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            if ($isFirstElement) {
                $map[$data[0]] = 0;
                $map[$data[1]] = 1;
                $map[$data[2]] = 2;
                $isFirstElement = 0;
                continue;
            }
            // Create a new product record
            if (count($mappings) !=  3) {
                return to_route('dashboard')->with('error','You should map columns correctly!');
            }
            if (!is_numeric($data[$map[$mappings[2]]])) {
                return to_route('dashboard')->with('error','You should map columns correctly!');
            }
            $product = new Product();
            $product->name = $data[$map[$mappings[0]]];
            $product->type = $data[$map[$mappings[1]]];
            $product->qty = $data[$map[$mappings[2]]];
            $product->save();
        }
        // Return a response
        return to_route('dashboard')->with('success','Successfully added to database');
    }



    public function importProductsWithoutMapping(Request $request)
    {
        // Get the file from the request
        $file = $request->file('file');
        // Load the Excel file
        $spreadsheet = IOFactory::load($file);
        // Get the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();
        $map = [];
        // Loop through the rows
        foreach ($worksheet->getRowIterator() as $row) {
            // Get the cell values
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $data = [];

            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            $map = $data;
            break;
        }

        $filename = $file->getClientOriginalName();
        // Move the uploaded file to a permanent location
        $path = $file->storeAs('uploads', $filename);

        $request->session()->put('file_path', $path);

        return view('show_excel',[
            'map' => $map,
        ]);
    }
}
