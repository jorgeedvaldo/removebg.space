#!/usr/bin/env node
/*
 * RemoveBG — server-side background-removal worker.
 *
 * Usage:  node remove-bg-worker.cjs <inputPath> <outputPath>
 *
 * Reads the source image, removes the background with the same AI model used
 * before (now @imgly/background-removal-node, running on the server with the
 * model cached server-side), and writes a transparent PNG to <outputPath>.
 *
 * Requires:  npm install   (installs @imgly/background-removal-node)
 */
const fs = require('fs');

(async () => {
  const [, , inputPath, outputPath] = process.argv;

  if (!inputPath || !outputPath) {
    console.error('usage: remove-bg-worker.cjs <input> <output>');
    process.exit(2);
  }

  // The package is ESM-only, so load it via dynamic import from this CJS file.
  const { removeBackground } = await import('@imgly/background-removal-node');

  const input = fs.readFileSync(inputPath); // Buffer == Uint8Array (accepted)

  const blob = await removeBackground(input, {
    output: { format: 'image/png' },
  });

  const buffer = Buffer.from(await blob.arrayBuffer());
  fs.writeFileSync(outputPath, buffer);
})().catch((err) => {
  console.error(err && err.stack ? err.stack : String(err));
  process.exit(1);
});
