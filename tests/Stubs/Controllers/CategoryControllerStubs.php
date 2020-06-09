<?php

namespace Tests\Stubs\Controllers;

use App\Http\Controllers\BasicCrudController;
use App\Models\Category;
use Illuminate\Http\Request;
use Tests\Stubs\Models\CategoryStubs;

class CategoryControllerStubs extends BasicCrudController
{
   protected function model()
   {
       return CategoryStubs::class;
   }
}
