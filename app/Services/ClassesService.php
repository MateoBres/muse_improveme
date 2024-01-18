<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Services\Contracts\ClassesService as ClassesServiceContract;

class ClassesService implements ClassesServiceContract
{
    public function listClasses(array $pagination): LengthAwarePaginatorContract
    {
        /** @var Collection $classes */
        $classes = session()->get('classes', collect())
            ->take($pagination['perPage'])
            ->skip($pagination['perPage']*($pagination['page']-1))
            ->values();

        return new LengthAwarePaginator($classes->toArray(), $classes->count(), $pagination['perPage'], $pagination['page']);
    }

    public function fetchClass(int $id): array
    {
        /** @var Collection $classes */
        $classes = session()->get('classes');

        return $classes->where('id', '=', $id)->first() ?: [];
    }

    public function createClass(array $data): array
    {
        /** @var Collection $classes */
        $classes = session()->get('classes', collect());
        $id = $classes->max(fn (array $class) => $class['id']) ?: 0;

        $data['id'] = ++$id;
        $data['created_at'] = now();

        session()->put('classes', $classes->push($data)->values());

        return $data;
    }

    public function updateClass(int $id, array $data): array
    {
        /** @var Collection $classes */
        $classes = session()->get('classes');
        $id = $classes->max(fn (array $class) => $class['id']);

        $data['id'] = ++$id;

        session()->put('classes', $classes->push($data)->values());

        return $data;
    }

    public function deleteClass(int $id, bool $force = false): array
    {
        if($force) {
            return $this->forceDeleteClass($id);
        }

        /** @var Collection $classes */
        $classes = session()->get('classes');
        /** @var Collection $trashed */
        $trashed = session()->get('classes.trashed');
        $class = $classes->where('id', '=', $id)->first();

        if($class !== null) {
            session()->put('classes', $classes->filter(fn ($resource) => $resource['id'] != $class['id'])->values());
            session()->put('classes.trashed', $trashed->push($class)->values());
        }

        return $class;
    }

    public function restoreClass(int $id): array
    {

        /** @var Collection $classes */
        $classes = session()->get('classes');
        /** @var Collection $trashed */
        $trashed = session()->get('classes.trashed');
        $class = $classes->where('id', '=', $id)->first();

        if($class !== null) {
            session()->put('classes', $classes->push($class)->values());
            session()->put('classes.trashed', $trashed->filter(fn ($resource) => $resource['id'] != $class['id'])->values());
        }
    }

    protected function forceDeleteClass(int $id): array
    {
        /** @var Collection $trashed */
        $trashed = session()->get('classes.trashed');
        $class = $trashed->where('id', '=', $id)->first();

        if($class !== null) {
            session()->put('classes.trashed', $trashed->filter(fn(array $trash) => $trash['id'] != $class['id'])->values());
        }

        return $class;
    }
}
