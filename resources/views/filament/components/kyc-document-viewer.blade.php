@if($document_url)
    @php
        $filename = basename($document_url);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        $documentUrl = route('admin.kyc.document', ['file' => $document_url, 'type' => $document_type]);
    @endphp
    
    <div class="space-y-2">
        @if($isImage)
            <!-- Image Preview -->
            <div class="relative">
                <img src="{{ $documentUrl }}" 
                     alt="ID {{ ucfirst($document_type) }} Document" 
                     class="max-w-full h-auto rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:shadow-md transition-shadow"
                     style="max-height: 300px;"
                     onclick="openDocumentModal('{{ $documentUrl }}', 'ID {{ ucfirst($document_type) }} Document')">
                <div class="absolute top-2 right-2">
                    <button type="button" 
                            class="bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600 transition-colors"
                            onclick="openDocumentModal('{{ $documentUrl }}', 'ID {{ ucfirst($document_type) }} Document')"
                            title="View Full Size">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </button>
                </div>
            </div>
        @else
            <!-- PDF or Other Document -->
            <div class="border border-gray-300 rounded-lg p-4 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm text-gray-600 mb-2">{{ strtoupper($extension) }} Document</p>
                <a href="{{ $documentUrl }}" 
                   target="_blank"
                   class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Document
                </a>
            </div>
        @endif
        
        <!-- File Info -->
        <div class="text-xs text-gray-500">
            <span class="font-medium">File:</span> {{ $filename }}
        </div>
    </div>
@else
    <div class="text-gray-500 italic">No document uploaded</div>
@endif

<!-- Modal for full-size image viewing -->
<div id="documentModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button type="button" 
                onclick="closeDocumentModal()"
                class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl font-bold">
            ×
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full rounded-lg">
        <div id="modalCaption" class="text-white text-center mt-2"></div>
    </div>
</div>

<script>
function openDocumentModal(url, caption) {
    document.getElementById('modalImage').src = url;
    document.getElementById('modalCaption').textContent = caption;
    document.getElementById('documentModal').classList.remove('hidden');
    document.getElementById('documentModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeDocumentModal() {
    document.getElementById('documentModal').classList.add('hidden');
    document.getElementById('documentModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
document.getElementById('documentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDocumentModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDocumentModal();
    }
});
</script>
