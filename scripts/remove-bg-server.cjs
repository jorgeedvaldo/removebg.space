#!/usr/bin/env node
/*
 * RemoveBG — persistent background-removal micro-service.
 *
 * Designed for cPanel "Setup Node.js App" (Phusion Passenger): set this file as
 * the application startup file. The AI model loads once and stays warm in
 * memory, so each request is fast.
 *
 * Endpoints:
 *   GET  /health  -> { ok: true }
 *   POST /remove  -> body: raw image bytes; returns: transparent PNG bytes
 *                    optional header X-Worker-Secret must match WORKER_SECRET
 *
 * Requires:  npm install   (express + @imgly/background-removal-node)
 */
const express = require('express');

const PORT   = process.env.PORT || 3000;
const SECRET = process.env.WORKER_SECRET || '';
const MAX    = process.env.WORKER_MAX_BYTES ? parseInt(process.env.WORKER_MAX_BYTES, 10) : 25 * 1024 * 1024;

const app = express();
app.use(express.raw({ type: '*/*', limit: MAX }));

// Load the AI library once at boot (ESM from a CJS file).
let removeBackground = null;
const ready = import('@imgly/background-removal-node')
  .then((m) => { removeBackground = m.removeBackground; })
  .catch((e) => { console.error('Failed to load model library:', e); });

app.get('/health', (_req, res) => {
  res.json({ ok: true, ready: removeBackground !== null });
});

app.post('/remove', async (req, res) => {
  if (SECRET && req.get('X-Worker-Secret') !== SECRET) {
    return res.status(401).json({ ok: false, error: 'unauthorized' });
  }
  if (!req.body || !req.body.length) {
    return res.status(400).json({ ok: false, error: 'empty body' });
  }

  try {
    await ready;
    if (!removeBackground) throw new Error('model not loaded');

    const blob = await removeBackground(req.body, { output: { format: 'image/png' } });
    const out  = Buffer.from(await blob.arrayBuffer());

    res.set('Content-Type', 'image/png');
    res.send(out);
  } catch (err) {
    console.error('remove failed:', err && err.stack ? err.stack : err);
    res.status(500).json({ ok: false, error: 'processing_failed' });
  }
});

app.listen(PORT, () => {
  console.log(`RemoveBG worker listening on port ${PORT}`);
});
