<?php

namespace Dcodegroup\PageBuilder\Http\Controllers\Admin;

use Dcodegroup\PageBuilder\Http\Requests\TemplateRequest;
use Dcodegroup\PageBuilder\Models\Template;
use Dcodegroup\PageBuilder\Routes;
use Dcodegroup\PageBuilder\Services\PageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct(protected PageService $pageService)
    {
    }

    public function index(Request $request): View
    {
        $query = Template::query();

        // Search filter
        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where('name', 'like', $term)
                ->orWhere('key', 'like', $term);
        }

        return view('page-builder::templates.index')
            ->with('templates', $query->orderByDesc('created_at')->paginate());
    }

    public function create(): View
    {
        return view('page-builder::templates.edit')
            ->with('template', new Template());
    }

    public function store(TemplateRequest $request): RedirectResponse
    {
        Template::query()->create($request->validated());

        return redirect()
            ->route(Routes::admin('templates.index'))
            ->with('status', 'Template was successfully created');
    }

    public function edit(Template $template): View
    {
        return view('page-builder::templates.edit')
            ->with('template', $template);
    }

    public function update(TemplateRequest $request, Template $template): RedirectResponse
    {
        $template->update($request->validated());

        return redirect()
            ->route(Routes::admin('templates.edit'), $template)
            ->with('status', 'Template was successfully updated');
    }

    public function destroy(Template $template): RedirectResponse
    {
        $template->delete();

        return redirect()
            ->route(Routes::admin('templates.index'))
            ->with('status', 'Template was successfully deleted');
    }
}
