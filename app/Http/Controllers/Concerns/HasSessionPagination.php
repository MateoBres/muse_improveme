<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait HasSessionPagination
{
    abstract public function paginationKey(): string;

    protected function withKey(string $suffix): string
    {
        return sprintf('%s.%s', $this->paginationKey(), $suffix);
    }

    public function resolvePaginationFrom(Request $request) {
        $perPage = $request->query('perPage');
        $page = $request->query('page');

        // Controllo se in sessione ho una chiave del tipo {sezione}.pagination dove {sezione} fa riferimento al controller
        if($request->session()->has($this->withKey('pagination'))) {

            // Se la chiave pagination è presente, controllo se i valori in query string sono in qualche modo differenti
            $this->checkSessionPagination($request, $perPage, $page);
        }

        // Se non è presente imposto i valori presi dal query string. Se non è presente niente in query string imposto i valori di default
        $request->session()->put($this->withKey('pagination.perPage'), $perPage ?: 15);
        $request->session()->put($this->withKey('pagination.page'), $page ?: 1);
    }

    private function checkSessionPagination(Request $request, ?int $perPage, ?int $page): void
    {
        // Controllo che perPage sia valorizzato e diverso da quanto già presente in sessione. In quel caso aggiorno il valore in sessione
        if($perPage !== null && $request->session()->get($this->withKey('pagination.perPage')) != $perPage) {
            $request->session()->put($this->withKey('pagination.perPage'), $perPage);
        }

        // Controllo che page sia valorizzato e diverso da quanto già presente in sessione. In quel caso aggiorno il valore in sessione
        if($page !== null && $request->session()->get($this->withKey('pagination.page')) != $page) {
            $request->session()->put($this->withKey('pagination.page'), $page);
        }
    }
}
