/* =====================================================================
   RemoveBG — AI Background Remover (removebg.space)
   Server-side processing: the image is uploaded, the background is removed
   on the server, and the resulting transparent PNG is returned as a URL.
   The client no longer downloads any AI model.
   Config is provided by window.BG_REMOVE_CFG (endpoint, csrf, lang).
   ===================================================================== */
(function () {
    'use strict';

    var currentFile = null;
    var resultUrl   = null;

    var CFG  = window.BG_REMOVE_CFG || {};
    var LANG = CFG.lang || {};

    /* ---- helpers ---- */
    function $(id) { return document.getElementById(id); }
    function show(id) { var el = $(id); if (el) el.style.display = 'block'; }
    function hide(id) { var el = $(id); if (el) el.style.display = 'none'; }
    function t(key) { return LANG[key] || key; }

    /* ---- init ---- */
    function init() {
        var uploadArea = $('bgUploadArea');
        var fileInput  = $('bgFileInput');
        if (!uploadArea || !fileInput) return;

        uploadArea.addEventListener('click', function () { fileInput.click(); });

        fileInput.addEventListener('change', function (e) {
            if (e.target.files && e.target.files[0]) handleFile(e.target.files[0]);
        });

        uploadArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });
        uploadArea.addEventListener('dragleave', function () {
            uploadArea.classList.remove('drag-over');
        });
        uploadArea.addEventListener('drop', function (e) {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            if (e.dataTransfer.files && e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
        });

        var btnRemove   = $('btnRemoveBg');
        var btnNew      = $('btnNewImage');
        var btnDownload = $('btnDownloadResult');
        var btnRetry    = $('btnRetryBg');

        if (btnRemove)   btnRemove.addEventListener('click', startProcessing);
        if (btnNew)      btnNew.addEventListener('click', resetTool);
        if (btnDownload) btnDownload.addEventListener('click', downloadResult);
        if (btnRetry)    btnRetry.addEventListener('click', retryProcessing);
    }

    /* ---- file handling ---- */
    function handleFile(file) {
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (validTypes.indexOf(file.type) === -1) {
            alert(t('invalid_format'));
            return;
        }
        if (file.size > 20 * 1024 * 1024) {
            alert(t('invalid_format'));
            return;
        }
        currentFile = file;
        resultUrl   = null;
        hide('bgErrorArea');

        var reader = new FileReader();
        reader.onload = function (e) {
            var img = $('bgOriginalPreview');
            if (img) img.src = e.target.result;
            updateFileInfo(file);
            hide('bgUploadArea');
            show('bgPreviewSection');
        };
        reader.readAsDataURL(file);
    }

    function updateFileInfo(file) {
        var nameEl = $('bgFileName');
        var sizeEl = $('bgFileSize');
        if (nameEl) nameEl.textContent = file.name;
        if (sizeEl) sizeEl.textContent = formatSize(file.size);
    }

    function formatSize(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(2) + ' MB';
    }

    /* ---- processing (server-side) ---- */
    function startProcessing() {
        if (!currentFile) return;

        hide('bgPreviewSection');
        hide('bgResultSection');
        hide('bgErrorArea');
        show('bgProgressArea');
        setProgress(0, t('uploading'));

        var form = new FormData();
        form.append('image', currentFile);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', CFG.endpoint, true);
        xhr.responseType = 'json';
        if (CFG.csrf) xhr.setRequestHeader('X-CSRF-TOKEN', CFG.csrf);
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 90);
                setProgress(pct, t('uploading'));
            }
        };
        // Upload finished — server is now processing (no granular progress).
        xhr.upload.onload = function () {
            setProgress(95, t('processing_image'));
        };

        xhr.onload = function () {
            var data = xhr.response;
            if (typeof data === 'string') {
                try { data = JSON.parse(data); } catch (e) { data = null; }
            }
            if (xhr.status >= 200 && xhr.status < 300 && data && data.ok && data.url) {
                resultUrl = data.url;
                setProgress(100, t('done_title'));
                setTimeout(showResult, 250);
            } else {
                handleFailure(data);
            }
        };
        xhr.onerror   = function () { handleFailure(null); };
        xhr.ontimeout = function () { handleFailure(null); };

        xhr.send(form);
    }

    function handleFailure(data) {
        var msg = t('error_msg');
        if (data && data.message === 'processing_failed') msg = t('error_msg');
        console.error('[RemoveBG] processing failed', data);
        showError(msg);
    }

    function retryProcessing() {
        hide('bgErrorArea');
        show('bgPreviewSection');
    }

    function setProgress(pct, msg) {
        var bar  = $('bgProgressBar');
        var text = $('bgProgressText');
        if (bar)  { bar.style.width = pct + '%'; bar.textContent = pct + '%'; }
        if (text) text.textContent = msg || '';
    }

    /* ---- result ---- */
    function showResult() {
        var img = $('bgResultPreview');
        if (img) img.src = resultUrl;
        hide('bgProgressArea');
        show('bgResultSection');
    }

    function downloadResult() {
        if (!resultUrl || !currentFile) return;
        var baseName = currentFile.name.replace(/\.[^/.]+$/, '');

        // Fetch the result and trigger a download with a friendly filename.
        fetch(resultUrl)
            .then(function (r) { return r.blob(); })
            .then(function (blob) {
                var url  = URL.createObjectURL(blob);
                var link = document.createElement('a');
                link.href     = url;
                link.download = baseName + '-no-bg.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                setTimeout(function () { URL.revokeObjectURL(url); }, 2000);
            })
            .catch(function () {
                // Fallback: open the result in a new tab.
                window.open(resultUrl, '_blank');
            });
    }

    /* ---- error ---- */
    function showError(msg) {
        var msgEl = $('bgErrorMessage');
        if (msgEl) msgEl.textContent = msg || t('error_msg');
        hide('bgProgressArea');
        hide('bgResultSection');
        // The error area lives inside the preview section, so that must be
        // visible too — otherwise the whole panel would render empty.
        show('bgPreviewSection');
        show('bgErrorArea');
    }

    /* ---- reset ---- */
    function resetTool() {
        currentFile = null;
        resultUrl   = null;

        var fi = $('bgFileInput');
        if (fi) fi.value = '';

        var oi = $('bgOriginalPreview');
        if (oi) oi.src = '';
        var ri = $('bgResultPreview');
        if (ri) ri.src = '';

        hide('bgPreviewSection');
        hide('bgProgressArea');
        hide('bgResultSection');
        hide('bgErrorArea');
        show('bgUploadArea');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
