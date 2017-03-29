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
            ->with('color', 'font_awesome')
            ->paginate();

        return view('note.list', [
            'pager' => $pager
        ]);
    }

    protected function destroy(Request $request, $id)
    {
        /**
         * @var $note Note
         */
        $note = $this->getNote($request, $id, false);

        abort_if($note->delete(), 204);
        abort(403);
    }

    protected function getNote(Request $request, $id, $decrypt = true)
    {
        $note = Note::query()
            ->with('color', 'font_awesome')
            ->find($id);

        abort_if(
            !$note,
            404,
            'Note not found'
        );

        abort_if(
            $note->user_id !== $request->user()->id,
            401,
            'Access Denied'
        );

        if ($decrypt && $request->method() === 'POST')
        {
            $note->text = (new Secure())
                ->secret($request->input('password'))
                ->decrypt($note->text);

            $note->encrypted = $note->crc32 !== crc32($note->text);
        }

        return $note;
    }

    public function show(Request $request, $id)
    {
        $note = $this->getNote($request, $id);

        return view('note.show', [
            'note' => $note
        ]);
    }

    public function update(Request $request, $id)
    {
        $note = $this->getNote($request, $id, false);

        $this->noteSave($request, $note);

        return redirect(route('note.show', ['note' => $note->id]));
    }

    public function edit(Request $request, $id)
    {
        $note = $this->getNote($request, $id);

        return view('note.edit', [
            'note'         => $note,
            'colors'       => Color::all(),
            'fontAwesomes' => FontAwesome::query()->orderBy('value')->get(),
        ]);
    }

    protected function noteSave(Request $request, Note $note)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', base_path('storage/purifier'));

        $purifier = new \HTMLPurifier($config);

        $title         = strip_tags($request->input('title'));
        $text          = $purifier->purify($request->input('text'));
        $help_password = $request->input('help_password') ?? null;

        if ($help_password)
        {
            $help_password = strip_tags($help_password);
        }

        $note->title           = $title;
        $note->text            = $text;
        $note->font_awesome_id = $request->input('fontAwesome');
        $note->user_id         = $request->user()->id;
        $note->encrypted       = $request->input('encrypted') === 'on';
        $note->color_id        = $request->input('color');
        $note->help_password   = $help_password;
        $note->crc32           = crc32($note->text);

        if ($note->encrypted)
        {
            $secure     = new Secure();
            $note->text = $secure
                ->secret($request->input('secret'))
                ->encrypt($note->text);
        }

        return $note->save();
    }

    /**
     * @param Request $request
     *
     * @return array|string
     */
    public function store(Request $request)
    {
        $note = new Note();

        $this->noteSave($request, $note);

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
            'fontAwesomes' => FontAwesome::query()->orderBy('value')->get(),
        ]);
    }

}
