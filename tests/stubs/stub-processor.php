<?php
/*
 * Test-only stand-in for the real Node worker. Ignores the input and writes a
 * small transparent PNG to the output path so the pipeline can be exercised
 * without installing the AI model.
 *
 * Usage: php stub-processor.php <input> <output>
 */
[$self, $input, $output] = $argv + [null, null, null];

if (! $output) {
    fwrite(STDERR, "usage: stub-processor.php <input> <output>\n");
    exit(2);
}

$im = imagecreatetruecolor(64, 64);
imagesavealpha($im, true);
imagefill($im, 0, 0, imagecolorallocatealpha($im, 0, 0, 0, 127));
imagefilledellipse($im, 32, 32, 44, 44, imagecolorallocate($im, 37, 99, 235));
imagepng($im, $output);
imagedestroy($im);
