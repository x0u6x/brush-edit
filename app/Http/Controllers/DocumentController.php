<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Tag;
use Dom\DocumentFragment;
use Illuminate\Http\Request;

use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Document::select('id', 'title', 'content', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->where('user_id', auth()->id())
            ->with('tags:name');

        // 検索文字列フィルタ
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // タグIDフィルタ
        if ($tagId = $request->query('tag_id')) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('id', $tagId);
            });
        }

        $documents = $query->paginate(10);
        $tags = Tag::whereHas('documents', function ($query) {
            $query->where('user_id', auth()->id());
        })->select('id', 'name')->get();

        return view('documents.directory', compact('documents', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //新しいDocumentモデル作成
        $document = Document::create([
            'user_id' => auth()->id(),
            'status' => 'draft', // 下書き状態
        ]);
        //editに直通
        return redirect()->route('document.edit', $document->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        return view('documents.edit', compact('document'));
    }
    //↑あとで細かく確認する

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $document = Document::findOrFail($id);
        $document->delete();
        return redirect()->route('document.index');
    }

    /* preview用 */
    public function preview($id)
    {

        try {
            $document = Document::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return view('documents.preview', compact('document'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'ドキュメントが見つかりません');
        }
    }


    /* 自動保存用 */
    public function updateApi(Request $request, $id)
    {
        $document = Document::where('id', $id)->where('user_id', auth()->id())
            ->firstOrFail();
        $document->update([
            'title' => empty($request->input('title')) ? '無題' : $request->input('title'),
            'content' => $request->input('content', ''),
        ]);
        return response()->json(['id' => $document->id]);
    }


    /* タグ取得用 */
    public function getTags(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        $tags = Tag::whereHas('documents', function ($q) use ($document) {
            $q->where('document_tag.document_id', $document->id);
        })->pluck('name')->toArray();

        return response()->json(['tags' => $tags]);
    }

    public function updateTags(Request $request, Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403);
        }

        $this->syncTags($document, $request->tags);

        $tags = Tag::whereHas('documents', function ($q) use ($document) {
            $q->where('document_tag.document_id', $document->id);
        })->pluck('name')->toArray();

        return response()->json([
            'success' => true,
            'tags' => $tags
        ]);
    }

    /* syncTagsメソッド */
    private function syncTags($document, $tagNames)
    {
        $tags = $tagNames ? array_map('trim', explode('#', $tagNames)) : [];
        $tags = array_filter($tags); // 空要素を除外
        $tagIds = [];

        foreach ($tags as $name) {
            if (empty($name)) continue;

            $tag = Tag::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }

        $document->tags()->sync($tagIds); // 空配列でもsync実行
    }
}
