<?php

namespace App\Http\Controllers;

use App\Model\Color;
use App\Model\FontAwesome;
use App\Model\Note;
use Deimos\Secure\Secure;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \InvalidArgumentException
     */
    public function index(Request $request)
    {
        $pager = Note::query()
            ->where('user_id', $request->user()->id)
            ->orderBy('updated_at', 'desc')
            ->paginate();

        return view('note.list', [
            'pager' => $pager
        ]);
    }

    protected function getNote(Request $request, $id)
    {
        $note = Note::query()
            ->where('user_id', $request->user()->id)
            ->find($id);

        if (!$note)
        {
            throw new \InvalidArgumentException('Access Denied');
        }

        return $note;
    }

    public function show(Request $request, $id)
    {
        $note = $this->getNote($request, $id);

        if ($request->method() === 'POST')
        {
            $note->text = (new Secure())
                ->secret($request->input('password'))
                ->decrypt($note->text);

            $note->encrypted = !$note->text;
        }

        return view('note.show', [
            'note' => $note
        ]);
    }

    public function update(Request $request, $id)
    {

        $note = $this->getNote($request, $id);

        return $request->input();

    }

    public function edit(Request $request, $id)
    {
        $note = $this->getNote($request, $id);

        if ($request->method() === 'POST')
        {
            $note->text = (new Secure())
                ->secret($request->input('password'))
                ->decrypt($note->text);

            $note->encrypted = !$note->text;
        }

        return view('note.edit', [
            'note'         => $note,
            'colors'       => Color::all(),
            'fontAwesomes' => FontAwesome::all(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return array|string
     */
    public function store(Request $request)
    {
        $note = new Note();

        $note->title           = $request->input('title');
        $note->text            = $request->input('text');
        $note->font_awesome_id = $request->input('fontAwesome');
        $note->user_id         = $request->user()->id;
        $note->encrypted       = $request->input('encrypted') === 'on';
        $note->color_id        = $request->input('color');

        if ($note->encrypted)
        {
            $secure     = new Secure();
            $note->text = $secure
                ->secret($request->input('secret'))
                ->encrypt($note->text);
        }

        $note->save();

        return redirect(route('note.edit', [
            'note' => $note->id
        ]));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('note.create', [
            'colors'       => Color::all(),
            'fontAwesomes' => FontAwesome::all(),
        ]);
    }

}
