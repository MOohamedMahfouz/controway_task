<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends Controller
{



    public function importProductsWithMapping(Request $request)
    {
        // Get the file from the request
        $file = $request->file('file');
        // Load the Excel file
        $spreadsheet = IOFactory::load($file);

        // Get the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get the column mappings from the request
        $mappings = $request->input('mappings');
        $mappings = array_merge($mappings,array('0' => $mappings["'name'"] ?? 0));
        $mappings = array_merge($mappings,array('1' => $mappings["'type'"] ?? 1));
        $mappings = array_merge($mappings,array('2' => $mappings["'qty'"] ?? 2));

        $mappings = array_flip($mappings);
        $data = $worksheet->toArray();

        $isFirstElement = 1;
        // Loop through the rows
        foreach ($worksheet->getRowIterator() as $row) {
            if ($isFirstElement) {
                $isFirstElement = 0;
                continue;
            }
            // Get the cell values
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $data = [];

            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            // Create a new product record
            if (count($mappings) !=  3) {
                return to_route('map-excel')->with('error','You should map columns correctly!');
            }
            $product = new Product();
            $product->name = $data[$mappings['name']];
            $product->type = $data[$mappings['type']];
            $product->qty = $data[$mappings['qty']];
            $product->save();
        }

        // Return a response
        return to_route('map-excel')->with('success','Successfully added to database');
    }



    public function importProductsWithoutMapping(Request $request)
    {
        // Get the file from the request
        $file = $request->file('file');
        // Load the Excel file
        $spreadsheet = IOFactory::load($file);

        // Get the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        $isFirstElement = 1;
        $map = [
            'products' => '0',
            'type' => '1',
            'qty' => '2',
        ];
        function mappingExcelField(array $data, $field,$map)
        {
            $fieldExsist = 0;
            for ($i = 0; $i < 3; $i++) {
                if ($data[$i] == $field) {
                    $map[$field] = $i;
                    $fieldExsist = 1;
                }
            }
            if ($fieldExsist === 0) {
                for ($i = 0; $i < 3; $i++) {
                    if ($field == 'type') {
                        if ($data[$i] === null && $i != $map['products']) {
                            $map['type'] = $i;
                            break;
                        }
                    } else if ($field == 'qty') {
                        if ($data[$i] === null && $i != $map['products'] && $i != $map['type']) {
                            $map['qty'] = $i;
                            break;
                        }
                    } else if ($field == 'products') {
                        if ($data[$i] === null) {
                            $map[$field] = $i;
                            break;
                        }
                    }
                }
            }
            return $map;
        }
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
                $map = mappingExcelField($data, 'products',$map);
                $map = mappingExcelField($data, 'type',$map);
                $map = mappingExcelField($data, 'qty',$map);
                $isFirstElement = 0;
                continue;
            }
            if (!is_numeric($data[$map['qty']])) {
                // the value is not a number
                return to_route('dashboard')->with('error','Quantity Column should be a number');
            }
            // Create a new product record
            $product = new Product();
            $product->name = $data[$map['products']];
            $product->type = $data[$map['type']];
            $product->qty = $data[$map['qty']];
            $product->save();
        }

        // Return a response
        return to_route('dashboard')->with('success','Successfully added to database');
    }
}
