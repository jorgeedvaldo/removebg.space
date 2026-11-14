<?php

return [
    // Features
    'feat_title' => 'Why Choose RemoveBG?',
    'feat_sub'   => 'A fast, private and completely free way to cut out the background of any photo.',
    'feat1_t' => 'Runs in Your Browser',
    'feat1_d' => 'The AI model is executed locally with WebAssembly, so there is no waiting in a server queue and no dependence on a remote processing service.',
    'feat2_t' => 'Private by Design',
    'feat2_d' => 'Your photos are never uploaded. Everything happens on your own device, which makes the tool safe for personal portraits, client work and confidential product shots.',
    'feat3_t' => 'Free With No Limits',
    'feat3_d' => 'Process as many images as you like. There is no account, no credit system, no daily quota and no watermark on the exported file.',
    'feat4_t' => 'Clean Edges',
    'feat4_d' => 'The segmentation model is trained to follow fine details such as hair, fur, fabric and thin straps, producing natural-looking cut-outs.',
    'feat5_t' => 'Transparent PNG Output',
    'feat5_d' => 'Every result is exported as a transparent PNG, ready to be dropped into design software, slide decks, websites or online store listings.',
    'feat6_t' => 'Works on Any Device',
    'feat6_d' => 'Use it on a laptop, tablet or phone. Any modern browser with WebAssembly support can run the tool without installing anything.',

    // Tips
    'tips_title' => 'Tips for the Best Results',
    'tips_sub'   => 'Small choices when taking or selecting a photo can make a big difference to the final cut-out.',
    'tip1_t' => 'Use Good Lighting',
    'tip1_d' => 'Even, soft light reveals the true outline of your subject. Harsh shadows and strong backlight can blur the boundary between subject and background.',
    'tip2_t' => 'Choose Contrast',
    'tip2_d' => 'A subject that clearly differs in color from its surroundings is easier to separate. A dark product on a light surface is a classic example.',
    'tip3_t' => 'Keep the Subject Sharp',
    'tip3_d' => 'Make sure the main subject is in focus. Motion blur or soft focus around the edges leads to softer, less precise cut-outs.',
    'tip4_t' => 'Start With High Resolution',
    'tip4_d' => 'Larger source images contain more edge detail. Upload the original file instead of a heavily compressed or screenshot copy whenever possible.',
    'tip5_t' => 'Avoid Clutter',
    'tip5_d' => 'A simple background with few overlapping objects helps the model decide what belongs to the subject and what does not.',
    'tip6_t' => 'Check on Different Colors',
    'tip6_d' => 'After exporting, place the PNG over a light and a dark background to confirm that the edges look clean in both situations.',

    // Guide
    'guide_title' => 'A Practical Guide to Removing Image Backgrounds',
    'guide_intro' => 'Whether you sell products online, design marketing material or simply want a tidy profile picture, these notes explain the key ideas behind clean background removal and how to get professional results.',
    'guide1_t' => 'What Is a Transparent PNG?',
    'guide1_d' => 'A PNG file can store an alpha channel, which records how transparent each pixel is. When a background is removed, those pixels become fully transparent, so the subject can be placed over any color, gradient or photo. JPG files cannot store transparency, which is why the exported result is always PNG.',
    'guide2_t' => 'Preparing Product Photos for Marketplaces',
    'guide2_d' => 'Marketplaces such as Amazon, eBay and Etsy usually ask for a clean, uncluttered main image. Remove the background, then place the PNG on a plain white canvas in your editor and export it at the size the marketplace recommends. Always read the platform image guidelines before uploading.',
    'guide3_t' => 'Creating Consistent Branding',
    'guide3_d' => 'Cut-outs make it easy to reuse the same photo across a website, a social post and a printed flyer. Transparent images let you match your brand colors, add soft shadows and keep a consistent look across every channel without taking new photos.',
    'guide4_t' => 'Troubleshooting Common Problems',
    'guide4_d' => 'If part of the subject disappears or some background remains, try a sharper image with more contrast between subject and surroundings. Very small subjects, glass, smoke and objects that match the background color are hard cases, and a different photo angle often solves them.',

    // More FAQ
    'faq_q6'  => 'Can I use the images commercially?',
    'faq_a6'  => 'The tool does not add any restriction to your files. You remain responsible for having the right to use the original photo, but the processed result can be used in personal and commercial projects.',
    'faq_q7'  => 'Does it work on mobile phones?',
    'faq_a7'  => 'Yes. Any modern mobile browser that supports WebAssembly can run the tool. Processing may take a little longer on older phones, and a Wi-Fi connection is recommended for the first model download.',
    'faq_q8'  => 'What is the maximum image size?',
    'faq_a8'  => 'You can upload JPG, PNG or WebP images up to 20MB. Very large photos need more memory, so on low-end devices you may get faster results by resizing them first.',
    'faq_q9'  => 'Why is part of my subject missing?',
    'faq_a9'  => 'This usually happens when the subject is similar in color to the background or is partly out of focus. Try a photo with better lighting and more contrast, then run the tool again.',
    'faq_q10' => 'Do I need to install anything?',
    'faq_a10' => 'No. There is nothing to download or install. Open the page, choose an image and download the transparent PNG. The AI model is cached by your browser after the first use.',

    // About
    'about_title' => 'About RemoveBG',
    'about_p1' => 'RemoveBG was created to make professional-quality background removal available to everyone, without subscriptions, hidden limits or privacy trade-offs. We believe that a task used by sellers, students, designers and creators every day should be simple, fast and free.',
    'about_p2' => 'Instead of sending your pictures to a remote server, the site delivers a compact AI model to your browser and lets your own device do the work. This approach keeps your files private, removes upload waiting time and allows us to keep the service free for everybody.',
    'about_p3' => 'We keep improving the interface, the documentation and the supported languages. If you have a suggestion or run into a problem, your feedback helps us make the tool better for the whole community.',
];
