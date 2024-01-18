<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HasSessionPagination;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ClassesService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassesController extends Controller
{
    use HasSessionPagination;

    protected ClassesService $classesService;

    public function __construct(ClassesService $classesService)
    {
        $this->classesService = $classesService;
    }

    public function paginationKey(): string
    {
        return 'admin.classes';
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $pagination = $request->session()->get($this->withKey('pagination'), [
            'perPage' => 15,
            'page' => 1
        ]);

        $classes = $this->classesService->listClasses($pagination);

        return response()->view('admin.classes.index', [
            'classes' => $classes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        return response()->view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request): Response
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:3'],
            'active' => ['filled', 'boolean']
        ]);

        // `validate` restituisce SOLO i campi validati. Quindi se ho altri campi da prendere in considerazione
        // devo usare altri metodi come `$request->only()`
        //$data = $request->only([
        //    'title', 'description', 'active', 'note'
        //]);

        $class = $this->classesService->createClass($data);

        return response()->view('admin.classes.show', ['class' => $class]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        $class = $this->classesService->createClass([/* TODO */]);

        return response()->view('admin.classes.show', ['class' => $class]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        // Se la richiesta è in put, allora sto cercando di togliere una risorsa dal cestino
        if($request->isMethod('PUT')) {
            $class = $this->classesService->restoreClass($id);

            return response()->view('admin.classes.show', ['class' => $class]);
        }

        // Altrimenti procedo all'update classico
        $class = $this->classesService->updateClass($id, [/* TODO */]);

        return response()->view('admin.classes.show', ['class' => $class]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function destroy(Request $request, int $id): Response
    {
        $class = $this->classesService->deleteClass($id, $request->input('force', false));

        return response()->view('admin.classes.index');
    }
}
