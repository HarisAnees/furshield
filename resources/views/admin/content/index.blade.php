@extends('admin.layouts.app')

@section('title', 'Pet Care Guides & Articles')
@section('page_title', 'Pet Care Knowledge Base')
@section('page_subtitle', 'Manage veterinary articles, pet nutrition advice, training tips, and published care blogs.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.content.index') }}" class="filter-pill-link {{ !request('category') ? 'active' : '' }}">
            All Guides
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('admin.content.index', ['category' => $cat]) }}" class="filter-pill-link {{ request('category') === $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.content.index') }}" class="toolbar-search">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search care articles..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.content.index', request()->only('category')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createContentModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Write New Article
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Article Title & Summary</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Published At</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contents as $article)
                    <tr>
                        <td style="max-width: 380px;">
                            <strong style="font-size: 13px; color: #0f172a; display: block; margin-bottom: 2px;">{{ $article->title }}</strong>
                            <p style="font-size: 11.5px; color: #64748b; margin: 0; line-height: 1.35;">
                                {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 95) }}
                            </p>
                        </td>
                        <td>
                            <span class="badge badge-teal">{{ $article->category }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.content.toggle', $article) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="badge {{ $article->is_published ? 'badge-success' : 'badge-gray' }}" style="border: none; cursor: pointer;" title="Click to toggle publishing">
                                    <span class="badge-dot"></span> {{ $article->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #64748b; font-size: 12px; white-space: nowrap;">
                            {{ $article->created_at ? $article->created_at->format('M d, Y') : '—' }}
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons">
                                <button type="button" class="btn btn-secondary btn-sm" onclick='editArticle(@json($article))'>Edit</button>
                                <form method="POST" action="{{ route('admin.content.destroy', $article) }}" onsubmit="return confirm('Delete article?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <span class="empty-state-icon">📖</span>
                                <h4>No articles found</h4>
                                <p>Write veterinary guidance and pet wellness guides for your users.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contents->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $contents->links() }}
        </div>
    @endif
</div>

<!-- Create Article Modal -->
<div class="modal-overlay" id="createContentModal">
    <div class="modal-box" style="max-width: 620px;">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Care Library</span>
                <h3>Publish Care Guide Article</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createContentModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.content.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Article Headline *</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Essential Dog Nutrition: What Every Owner Needs to Know">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category" class="form-select" required>
                            <option value="Nutrition">Nutrition & Diet</option>
                            <option value="Preventive Care">Preventive Care</option>
                            <option value="Training & Behavior">Training & Behavior</option>
                            <option value="First Aid & Health">First Aid & Health</option>
                            <option value="Grooming">Grooming & Hygiene</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="is_published" value="1" checked>
                            <span>Publish Immediately to Owner Portal</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Article Body & Medical Advice *</label>
                    <textarea name="content" class="form-textarea" style="min-height: 160px;" required placeholder="Write clear, comprehensive veterinary recommendations..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createContentModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Publish Guide</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Article Modal -->
<div class="modal-overlay" id="editContentModal">
    <div class="modal-box" style="max-width: 620px;">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Care Guide CMS</span>
                <h3>Edit Care Guide</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('editContentModal')" aria-label="Close modal">&times;</button>
        </div>
        <form id="editContentForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Article Headline *</label>
                    <input type="text" name="title" id="edit_art_title" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category" id="edit_art_category" class="form-select" required>
                            <option value="Nutrition">Nutrition & Diet</option>
                            <option value="Preventive Care">Preventive Care</option>
                            <option value="Training & Behavior">Training & Behavior</option>
                            <option value="First Aid & Health">First Aid & Health</option>
                            <option value="Grooming">Grooming & Hygiene</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="is_published" id="edit_art_published" value="1">
                            <span>Published to Owner Portal</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Article Body & Medical Advice *</label>
                    <textarea name="content" id="edit_art_content" class="form-textarea" style="min-height: 160px;" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editContentModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
function editArticle(art) {
    document.getElementById('editContentForm').action = '/admin/content/' + art.id;
    document.getElementById('edit_art_title').value = art.title || '';
    document.getElementById('edit_art_category').value = art.category || 'Nutrition';
    document.getElementById('edit_art_published').checked = !!art.is_published;
    document.getElementById('edit_art_content').value = art.content || '';
    openModal('editContentModal');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
@endsection
