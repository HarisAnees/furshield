@extends('owner.layouts.app')

@section('title', 'Pet Care & Veterinary Guides')

@section('content')
<div class="owner-subpage-card">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <i class="fa-solid fa-lightbulb" style="color: #10b981;"></i> Pet Care Knowledge & Veterinary Advice
        </div>
        <span style="font-size: 12px; color: #64748b;">{{ $articles->count() }} Articles Published</span>
    </div>
    <div class="owner-subpage-body">
        <div class="owner-cards-grid">
            @forelse($articles as $art)
                <div style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="height: 140px; background: #f1f5f9; overflow: hidden; position: relative;">
                        <img src="/images/care-tips.jpg" alt="{{ $art->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); color: #ffffff; font-size: 10.5px; font-weight: 700; padding: 3px 10px; border-radius: 12px;">
                            {{ $art->category }}
                        </span>
                    </div>

                    <div style="padding: 18px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <strong style="font-size: 15px; color: #0f172a; display: block; margin-bottom: 6px; line-height: 1.3;">
                                {{ $art->title }}
                            </strong>
                            <p style="font-size: 12.5px; color: #64748b; line-height: 1.45; margin-bottom: 14px;">
                                {{ \Illuminate\Support\Str::limit(strip_tags($art->content), 120) }}
                            </p>
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; padding-top: 12px; display: flex; align-items: center; justify-content: space-between;">
                            <small style="color: #94a3b8; font-size: 11.5px;">
                                {{ $art->created_at ? $art->created_at->format('M d, Y') : 'Recent' }}
                            </small>
                            <button type="button" class="owner-btn owner-btn-secondary" style="font-size: 11.5px; padding: 5px 12px;" onclick='openArticleModal(@json($art))'>
                                Read Guide →
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                    <h4>No guides published yet</h4>
                    <p style="font-size: 12px;">Check back soon for veterinary health articles and pet care advice.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Read Article Modal -->
<div class="owner-modal-overlay" id="readArticleModal">
    <div class="owner-modal-box">
        <div class="owner-modal-header">
            <div>
                <span id="read_art_cat" style="font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase;">CATEGORY</span>
                <h3 id="read_art_title" style="margin-top: 4px; font-size: 16px;">Article Title</h3>
            </div>
            <button class="owner-modal-close" onclick="closeOwnerModal('readArticleModal')">&times;</button>
        </div>
        <div class="owner-modal-body" style="line-height: 1.6; color: #334155; font-size: 13.5px; white-space: pre-line;" id="read_art_body">
            Article body goes here...
        </div>
        <div class="owner-modal-footer">
            <button type="button" class="owner-btn owner-btn-secondary" onclick="closeOwnerModal('readArticleModal')">Close</button>
        </div>
    </div>
</div>

<script>
function openArticleModal(art) {
    document.getElementById('read_art_cat').innerText = art.category || 'General Care';
    document.getElementById('read_art_title').innerText = art.title || '';
    document.getElementById('read_art_body').innerText = art.content || '';
    document.getElementById('readArticleModal').classList.add('active');
}
function closeOwnerModal(id) { document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.owner-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
@endsection
