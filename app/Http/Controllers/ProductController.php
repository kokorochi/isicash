<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\SubCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller {
    public function __construct()
    {
        $this->middleware('auth')->only('adminIndex', 'create', 'getProductDatatable');
    }

    public function index()
    {
        $categories = Category::all();
        $category = new Category();
        $category->id = 0;
        $category->name = 'Semua Produk';
        $categories->prepend($category);

        $input = Input::all();
        if (isset($input['category_code']) && isset($input['sub_category_code']))
        {
            $products = Product::where('category_code', $input['category_code'])
                ->where('sub_category_code', $input['sub_category_code'])
                ->get();
        } else
        {
            $products = Product::all();
        }

        foreach ($categories as $category)
        {
            if ($category->id == 0)
            {
                $category['product_count'] = Product::all()->count();
            } else
            {
                $category['product_count'] = Product::where('category_code', $category->category_code)->count();
            }
        }

        return view('product.product-list-public', compact('categories', 'products'));
    }

    public function detail()
    {
        $input = Input::all();
        if (isset($input['product_id']))
        {
            $pages_js[] = 'js/jquery.inputmask.bundle.js';

            $product = Product::find($input['product_id']);
            if (is_null($product)) return abort('404');

            $categories = Category::all();
            $category = new Category();
            $category->id = 0;
            $category->name = 'Semua Produk';
            $categories->prepend($category);

            return view('product.product-detail-public', compact('product', 'categories', 'pages_js'));
        } else
        {
            return abort('404');
        }
    }

    public function adminIndex()
    {
        $this->authorize('adminList', Product::class);

        return view('admin.product-list');
    }

    public function create()
    {
        $this->authorize('create', Product::class);

        $pages['upd_mode'] = 'create';

        $data = [
            'category_id'     => '1',
            'sub_category_id' => '1',
            'name'            => '',
            'description'     => '',
        ];

        return view('admin.product-detail', compact('data', 'pages'));
    }

    public function getProductDatatable()
    {
        $input = Input::all();
        dd($input);
        $this->authorize('adminList', Product::class);


//        $i = 0;
//        $data = [];
//        foreach ($proposes_final as $propose)
//        {
//            if ($type === 'ELSE')
//            {
//                $data['data'][$i][0] = $propose->id;
//            } else
//            {
//                $data['data'][$i][0] = $i + 1;
//                $data['data'][$i][1] = $propose->title;
//                $data['data'][$i][2] = Lecturer::where('employee_card_serial_number', $propose->created_by)->first()->full_name;
//                if ($propose->is_own === '1')
//                {
//                    $data['data'][$i][3] = $propose->proposesOwn()->first()->scheme;
//                } else
//                {
//                    $data['data'][$i][3] = $period->scheme;
//                }
//                $data['data'][$i][4] = $propose->flowStatus()->orderBy('item', 'desc')->first()->statusCode()->first()->description;
//                if ($type === 'ASSIGN')
//                {
//                    $data['data'][$i][5] = '<td class="text-center"><a href="' . url('reviewers/assign', $propose->id) . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Assign"><i class="fa fa-plus-circle"></i></a></td>';
//                } elseif ($type === 'APPROVE')
//                {
//                    if ($propose->status_code === 'RS')
//                    {
//                        $data['data'][$i][5] = '<td class="text-center"><a href="' . url('approve-proposes', $propose->id) . '/approve' . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Approve"><i class="fa fa-check-square-o"></i></a></td>';
//                    } else
//                    {
//                        $data['data'][$i][5] = '<td class="text-center"><a href="' . url('approve-proposes', $propose->id) . '/display' . '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Detail"><i class="fa fa-search-plus"></i></a></td>';
//                    }
//                }
//            }
//
//            $i++;
//        }
//        $count_data = count($data);
//        if ($count_data == 0)
//        {
//            $data['data'] = [];
//        }
//        $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $count_data;
//        $data = json_encode($data, JSON_PRETTY_PRINT);
//
//        return response($data, 200)->header('Content-Type', 'application/json');
    }
}
