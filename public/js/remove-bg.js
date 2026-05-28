/* =====================================================================
   RemoveBG — AI Background Remover (removebg.space)
   Loaded via esm.sh (resolves onnxruntime-web peer dep automatically)
   window.bgRemoval is set by the <script type="module"> in the view.
   ===================================================================== */
(function () {
    'use strict';

    var currentFile = null;
    var resultBlob  = null;
    var libReady    = false;

    /* ---- helpers ---- */
    function $(id) { return document.getElementById(id); }
    function show(id) { var el = $(id); if (el) el.style.display = 'block'; }
    function hide(id) { var el = $(id); if (el) el.style.display = 'none'; }
    function t(key) { return (window.BG_REMOVE_LANG && window.BG_REMOVE_LANG[key]) || key; }

    function getLib() {
        return (window.bgRemoval && typeof window.bgRemoval.removeBackground === 'function')
            ? window.bgRemoval : null;
    }

    /* ---- library loading state ---- */
    function onLibReady() {
        libReady = true;
        var btn = $('btnRemoveBg');
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('btn-disabled-loading');
        }
        // If the user already clicked while loading, start now
        if (window._bgPendingProcess) {
            window._bgPendingProcess = false;
            startProcessing();
        }
    }

    /* ---- init ---- */
    function init() {
        var uploadArea = $('bgUploadArea');
        var fileInput  = $('bgFileInput');
        if (!uploadArea || !fileInput) return;

        // Disable remove button until lib ready
        var btnRemove = $('btnRemoveBg');
        if (btnRemove) {
            btnRemove.disabled = true;
            btnRemove.classList.add('btn-disabled-loading');
            btnRemove.title = t('loading_model') || 'Loading AI...';
        }

        // Listen for library ready event (dispatched by module script)
        document.addEventListener('bgRemovalReady', onLibReady, { once: true });

        // If library already loaded (cached module), enable immediately
        if (getLib()) onLibReady();

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
        resultBlob  = null;
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

    /* ---- processing ---- */
    function startProcessing() {
        if (!currentFile) return;

        var lib = getLib();
        if (!lib) {
            // Library still loading — show progress and wait
            hide('bgPreviewSection');
            show('bgProgressArea');
            setProgress(2, t('loading_model'));
            window._bgPendingProcess = true;
            return;
        }

        hide('bgPreviewSection');
        hide('bgResultSection');
        hide('bgErrorArea');
        show('bgProgressArea');
        setProgress(0, t('loading_model'));

        var config = {
            // Default publicPath points to staticimgly.com CDN (imgly's own CDN)
            model: 'small',
            output: {
                format: 'image/png',
                type:   'foreground'
            },
            progress: function (key, current, total) {
                var pct = (total > 0) ? Math.min(Math.round((current / total) * 100), 99) : 0;
                var msg = (key && key.indexOf('fetch') !== -1)
                    ? t('loading_model')
                    : t('processing_image');
                setProgress(pct, msg);
            }
        };

        lib.removeBackground(currentFile, config)
            .then(function (blob) {
                resultBlob = blob;
                setProgress(100, t('done_title'));
                setTimeout(showResult, 350);
            })
            .catch(function (err) {
                console.error('[RemoveBG]', err);
                hide('bgProgressArea');
                showError(t('error_msg'));
            });
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
        var url = URL.createObjectURL(resultBlob);
        var img = $('bgResultPreview');
        if (img) img.src = url;
        hide('bgProgressArea');
        show('bgResultSection');
    }

    function downloadResult() {
        if (!resultBlob || !currentFile) return;
        var baseName = currentFile.name.replace(/\.[^/.]+$/, '');
        var url  = URL.createObjectURL(resultBlob);
        var link = document.createElement('a');
        link.href     = url;
        link.download = baseName + '-no-bg.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        setTimeout(function () { URL.revokeObjectURL(url); }, 2000);
    }

    /* ---- error ---- */
    function showError(msg) {
        var msgEl = $('bgErrorMessage');
        if (msgEl) msgEl.textContent = msg || t('error_msg');
        hide('bgProgressArea');
        show('bgErrorArea');
    }

    /* ---- reset ---- */
    function resetTool() {
        if (resultBlob) {
            var old = $('bgResultPreview');
            if (old && old.src && old.src.startsWith('blob:')) URL.revokeObjectURL(old.src);
        }
        currentFile = null;
        resultBlob  = null;
        window._bgPendingProcess = false;

        var fi = $('bgFileInput');
        if (fi) fi.value = '';

        var oi = $('bgOriginalPreview');
        if (oi) oi.src = '';

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
