<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use Component\Product\Domain\Repository\ProductRepository;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductRepository $repository){}

    public function index(): View
    {
        return view('products.index', [
            'products' => $this->repository->all()
        ]);
    }
}
