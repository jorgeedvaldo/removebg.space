<?php

return [
    // Features
    'feat_title' => 'Pourquoi choisir RemoveBG ?',
    'feat_sub'   => 'Un moyen rapide, privé et entièrement gratuit de détourer l\'arrière-plan de n\'importe quelle photo.',
    'feat1_t' => 'Fonctionne dans votre navigateur',
    'feat1_d' => 'Le modèle d\'IA s\'exécute localement avec WebAssembly : pas de file d\'attente sur un serveur et aucune dépendance à un service de traitement distant.',
    'feat2_t' => 'Privé par conception',
    'feat2_d' => 'Vos photos ne sont jamais envoyées. Tout se passe sur votre propre appareil, ce qui rend l\'outil sûr pour les portraits personnels, le travail de clients et les photos de produits confidentielles.',
    'feat3_t' => 'Gratuit et sans limite',
    'feat3_d' => 'Traitez autant d\'images que vous le souhaitez. Aucun compte, aucun système de crédits, aucun quota quotidien et aucun filigrane sur le fichier exporté.',
    'feat4_t' => 'Contours nets',
    'feat4_d' => 'Le modèle de segmentation est entraîné à suivre les détails fins comme les cheveux, les poils, les tissus et les bretelles fines, pour des détourages naturels.',
    'feat5_t' => 'Sortie en PNG transparent',
    'feat5_d' => 'Chaque résultat est exporté en PNG transparent, prêt à être utilisé dans un logiciel de design, une présentation, un site web ou une fiche de boutique en ligne.',
    'feat6_t' => 'Fonctionne sur tous les appareils',
    'feat6_d' => 'Utilisez-le sur ordinateur, tablette ou téléphone. Tout navigateur moderne compatible WebAssembly exécute l\'outil sans rien installer.',

    // Tips
    'tips_title' => 'Conseils pour de meilleurs résultats',
    'tips_sub'   => 'De petits choix lors de la prise de vue ou de la sélection d\'une photo changent beaucoup le détourage final.',
    'tip1_t' => 'Soignez l\'éclairage',
    'tip1_d' => 'Une lumière douce et uniforme révèle le vrai contour de votre sujet. Les ombres dures et le fort contre-jour peuvent brouiller la limite entre sujet et arrière-plan.',
    'tip2_t' => 'Cherchez le contraste',
    'tip2_d' => 'Un sujet dont la couleur diffère nettement de son environnement est plus facile à séparer. Un produit sombre sur une surface claire en est l\'exemple classique.',
    'tip3_t' => 'Gardez le sujet net',
    'tip3_d' => 'Assurez-vous que le sujet principal est net. Un flou de bougé ou une mise au point douce sur les bords donne des détourages moins précis.',
    'tip4_t' => 'Partez d\'une haute résolution',
    'tip4_d' => 'Les grandes images contiennent plus de détails sur les contours. Si possible, envoyez le fichier d\'origine plutôt qu\'une copie très compressée ou une capture d\'écran.',
    'tip5_t' => 'Évitez l\'encombrement',
    'tip5_d' => 'Un arrière-plan simple, avec peu d\'objets qui se chevauchent, aide le modèle à décider ce qui appartient au sujet ou non.',
    'tip6_t' => 'Testez sur différentes couleurs',
    'tip6_d' => 'Après l\'export, placez le PNG sur un fond clair puis sur un fond sombre pour vérifier que les contours restent propres dans les deux cas.',

    // Guide
    'guide_title' => 'Guide pratique pour supprimer l\'arrière-plan d\'une image',
    'guide_intro' => 'Que vous vendiez des produits en ligne, conceviez du matériel marketing ou souhaitiez simplement une photo de profil soignée, ces notes expliquent les principes d\'une bonne suppression d\'arrière-plan et comment obtenir un résultat professionnel.',
    'guide1_t' => 'Qu\'est-ce qu\'un PNG transparent ?',
    'guide1_d' => 'Un fichier PNG peut contenir un canal alpha, qui indique la transparence de chaque pixel. Quand l\'arrière-plan est supprimé, ces pixels deviennent totalement transparents et le sujet peut être placé sur n\'importe quelle couleur, dégradé ou photo. Le JPG ne gère pas la transparence : c\'est pourquoi le résultat exporté est toujours un PNG.',
    'guide2_t' => 'Préparer des photos de produits pour les places de marché',
    'guide2_d' => 'Des plateformes comme Amazon, eBay et Etsy demandent généralement une image principale propre et sans éléments superflus. Supprimez l\'arrière-plan, placez le PNG sur un fond blanc dans votre éditeur et exportez-le à la taille recommandée. Lisez toujours les consignes d\'image de la plateforme avant l\'envoi.',
    'guide3_t' => 'Garder une image de marque cohérente',
    'guide3_d' => 'Les détourages permettent de réutiliser la même photo sur un site, une publication sociale et un flyer imprimé. Les images transparentes permettent d\'harmoniser les couleurs de la marque, d\'ajouter des ombres douces et de garder un rendu identique sur tous les canaux sans refaire de photos.',
    'guide4_t' => 'Résoudre les problèmes courants',
    'guide4_d' => 'Si une partie du sujet disparaît ou qu\'il reste du fond, essayez une image plus nette et plus contrastée entre sujet et environnement. Les sujets très petits, le verre, la fumée et les objets de la couleur du fond sont des cas difficiles ; changer d\'angle de prise de vue règle souvent le problème.',

    // More FAQ
    'faq_q6'  => 'Puis-je utiliser les images à des fins commerciales ?',
    'faq_a6'  => 'L\'outil n\'ajoute aucune restriction à vos fichiers. Vous restez responsable de disposer des droits sur la photo d\'origine, mais le résultat traité peut servir à des projets personnels et commerciaux.',
    'faq_q7'  => 'Cela fonctionne-t-il sur mobile ?',
    'faq_a7'  => 'Oui. Tout navigateur mobile moderne compatible WebAssembly peut exécuter l\'outil. Le traitement peut être un peu plus long sur un ancien téléphone, et le Wi-Fi est recommandé pour le premier téléchargement du modèle.',
    'faq_q8'  => 'Quelle est la taille maximale d\'image ?',
    'faq_a8'  => 'Vous pouvez envoyer des images JPG, PNG ou WebP jusqu\'à 20 Mo. Les très grandes photos demandent plus de mémoire : sur un appareil modeste, les redimensionner d\'abord peut accélérer le traitement.',
    'faq_q9'  => 'Pourquoi une partie de mon sujet a-t-elle disparu ?',
    'faq_a9'  => 'Cela arrive en général lorsque le sujet a une couleur proche de l\'arrière-plan ou est en partie flou. Essayez une photo mieux éclairée et plus contrastée, puis relancez l\'outil.',
    'faq_q10' => 'Dois-je installer quelque chose ?',
    'faq_a10' => 'Non. Il n\'y a rien à télécharger ni à installer. Ouvrez la page, choisissez une image et téléchargez le PNG transparent. Le modèle d\'IA est mis en cache par votre navigateur après la première utilisation.',

    // About
    'about_title' => 'À propos de RemoveBG',
    'about_p1' => 'RemoveBG a été créé pour rendre la suppression d\'arrière-plan de qualité professionnelle accessible à tous, sans abonnement, sans limite cachée et sans compromis sur la vie privée. Nous pensons qu\'une tâche utilisée chaque jour par des vendeurs, des étudiants, des designers et des créateurs doit être simple, rapide et gratuite.',
    'about_p2' => 'Au lieu d\'envoyer vos images vers un serveur distant, le site fournit un modèle d\'IA compact à votre navigateur et laisse votre propre appareil faire le travail. Cette approche protège vos fichiers, supprime l\'attente d\'envoi et nous permet de garder le service gratuit pour tous.',
    'about_p3' => 'Nous continuons d\'améliorer l\'interface, la documentation et les langues disponibles. Si vous avez une suggestion ou rencontrez un problème, vos retours nous aident à améliorer l\'outil pour toute la communauté.',
];
