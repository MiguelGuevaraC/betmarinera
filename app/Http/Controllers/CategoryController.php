<?php
namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest\IndexCategoryContestActiveRequest;
use App\Http\Requests\CategoryRequest\IndexCategoryRequest;
use App\Http\Requests\CategoryRequest\StoreCategoryRequest;
use App\Http\Requests\CategoryRequest\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceBet;
use App\Models\Category;
use App\Models\Contest;
use App\Models\Contestant;
use App\Services\CategoryService;
use App\Services\ContestantService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categorytService;
    protected $contestantService;
    public function __construct(CategoryService $categorytService,ContestantService $contestantService)
    {
        $this->categorytService = $categorytService;
        $this->contestantService = $contestantService;
    }

    public function list(IndexCategoryRequest $request)
    {

        return $this->getFilteredResults(
            Category::class,
            $request,
            Category::filters,
            Category::sorts,
            CategoryResource::class
        );
    }

    public function list_contest_active(IndexCategoryContestActiveRequest $request)
    {
        return $this->getFilteredResults(
            Category::class,
            $request,
            Category::filters,
            Category::sorts,
            CategoryResourceBet::class
        );
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categorytService->createCategory($request->validated());
        $this->contestantService->createContestant([
            'names'=>'Otros',
            'description'=>'Participante por defecto',
            'category_id'=>$category->id,
            'contest_id'=>$category->contest_id
        ]);
        return new CategoryResource($category);
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        $validatedData = $request->validated();

        $category = $this->categorytService->getCategoryById($id);
        if (! $category) {
            return response()->json([
                'error' => 'Categorya no encontrada',
            ], 404);
        }

        $updatedCompany = $this->categorytService->updateCategory($category, $validatedData);
        return new CategoryResource($updatedCompany);
    }
    public function updateWin(Request $request, $id)
    {
        $contestanwin_id = $request->get('contestantwin_id');

        $category = $this->categorytService->getCategoryById($id);
        if (! $category) {
            return response()->json([
                'error' => 'Categorya no encontrada',
            ], 404);
        }
        $contestant=Contestant::find($contestanwin_id);
        if (! $contestant) {
            return response()->json([
                'message' => 'Concursante no encontrado.',
            ], 422);
        }
        $updatedCompany = $this->categorytService->updateCategoryWin($category, $contestanwin_id);
        return new CategoryResource($updatedCompany);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json([
                'message' => 'Categoria no encontrado.',
            ], 404);
        }

        if ($category->contestants()->exists()) {
            return response()->json([
                'message' => 'El concurso tiene concursantes asociados.',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categoria eliminado exitosamente.',
        ], 200);
    }
}
