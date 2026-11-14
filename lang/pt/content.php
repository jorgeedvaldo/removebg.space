<?php

return [
    // Features
    'feat_title' => 'Por que escolher o RemoveBG?',
    'feat_sub'   => 'Uma forma rápida, privada e totalmente gratuita de recortar o fundo de qualquer foto.',
    'feat1_t' => 'Roda no seu navegador',
    'feat1_d' => 'O modelo de IA é executado localmente com WebAssembly, sem fila de servidor e sem depender de um serviço de processamento remoto.',
    'feat2_t' => 'Privado por natureza',
    'feat2_d' => 'Suas fotos nunca são enviadas. Tudo acontece no seu próprio dispositivo, o que torna a ferramenta segura para retratos pessoais, trabalhos de clientes e fotos confidenciais de produtos.',
    'feat3_t' => 'Grátis e sem limites',
    'feat3_d' => 'Processe quantas imagens quiser. Não há conta, sistema de créditos, cota diária nem marca d\'água no arquivo exportado.',
    'feat4_t' => 'Bordas limpas',
    'feat4_d' => 'O modelo de segmentação é treinado para seguir detalhes finos como cabelo, pelos, tecidos e alças finas, gerando recortes de aparência natural.',
    'feat5_t' => 'Saída em PNG transparente',
    'feat5_d' => 'Todo resultado é exportado como PNG transparente, pronto para usar em programas de design, apresentações, sites ou anúncios de lojas online.',
    'feat6_t' => 'Funciona em qualquer dispositivo',
    'feat6_d' => 'Use no notebook, tablet ou celular. Qualquer navegador moderno com suporte a WebAssembly executa a ferramenta sem instalar nada.',

    // Tips
    'tips_title' => 'Dicas para obter os melhores resultados',
    'tips_sub'   => 'Pequenas escolhas ao tirar ou selecionar uma foto fazem grande diferença no recorte final.',
    'tip1_t' => 'Use boa iluminação',
    'tip1_d' => 'Uma luz suave e uniforme revela o contorno real do seu objeto. Sombras duras e contraluz forte podem confundir a fronteira entre objeto e fundo.',
    'tip2_t' => 'Escolha contraste',
    'tip2_d' => 'Um objeto com cor bem diferente do ambiente é mais fácil de separar. Um produto escuro sobre uma superfície clara é um exemplo clássico.',
    'tip3_t' => 'Mantenha o objeto nítido',
    'tip3_d' => 'Garanta que o objeto principal esteja em foco. Desfoque de movimento ou foco suave nas bordas geram recortes menos precisos.',
    'tip4_t' => 'Comece com alta resolução',
    'tip4_d' => 'Imagens maiores contêm mais detalhes de borda. Sempre que possível, envie o arquivo original em vez de uma cópia muito comprimida ou captura de tela.',
    'tip5_t' => 'Evite poluição visual',
    'tip5_d' => 'Um fundo simples, com poucos objetos sobrepostos, ajuda o modelo a decidir o que pertence ao objeto e o que não pertence.',
    'tip6_t' => 'Teste em cores diferentes',
    'tip6_d' => 'Depois de exportar, coloque o PNG sobre um fundo claro e outro escuro para confirmar que as bordas ficam limpas nas duas situações.',

    // Guide
    'guide_title' => 'Guia prático para remover fundos de imagens',
    'guide_intro' => 'Seja para vender produtos online, criar material de marketing ou ter uma foto de perfil impecável, estas notas explicam as ideias por trás de uma boa remoção de fundo e como alcançar resultados profissionais.',
    'guide1_t' => 'O que é um PNG transparente?',
    'guide1_d' => 'Um arquivo PNG pode guardar um canal alfa, que registra o quanto cada pixel é transparente. Ao remover o fundo, esses pixels ficam totalmente transparentes e o objeto pode ser colocado sobre qualquer cor, gradiente ou foto. Arquivos JPG não guardam transparência, por isso o resultado exportado é sempre PNG.',
    'guide2_t' => 'Preparando fotos de produtos para marketplaces',
    'guide2_d' => 'Marketplaces como Amazon, eBay e Etsy costumam exigir uma imagem principal limpa e sem elementos extras. Remova o fundo, coloque o PNG sobre uma tela branca no seu editor e exporte no tamanho recomendado pela plataforma. Leia sempre as diretrizes de imagem antes de enviar.',
    'guide3_t' => 'Criando uma identidade visual consistente',
    'guide3_d' => 'Recortes facilitam reutilizar a mesma foto em um site, em uma postagem social e em um panfleto impresso. Imagens transparentes permitem combinar as cores da marca, adicionar sombras suaves e manter o mesmo visual em todos os canais sem fazer novas fotos.',
    'guide4_t' => 'Resolvendo problemas comuns',
    'guide4_d' => 'Se parte do objeto sumir ou sobrar fundo, tente uma imagem mais nítida e com mais contraste entre objeto e entorno. Objetos muito pequenos, vidro, fumaça e itens da mesma cor do fundo são casos difíceis, e outro ângulo de foto costuma resolver.',

    // More FAQ
    'faq_q6'  => 'Posso usar as imagens comercialmente?',
    'faq_a6'  => 'A ferramenta não adiciona nenhuma restrição aos seus arquivos. Você continua responsável por ter o direito de usar a foto original, mas o resultado processado pode ser usado em projetos pessoais e comerciais.',
    'faq_q7'  => 'Funciona em celulares?',
    'faq_a7'  => 'Sim. Qualquer navegador móvel moderno com suporte a WebAssembly executa a ferramenta. Em celulares mais antigos o processamento pode demorar um pouco mais, e recomendamos Wi-Fi no primeiro download do modelo.',
    'faq_q8'  => 'Qual é o tamanho máximo da imagem?',
    'faq_a8'  => 'Você pode enviar imagens JPG, PNG ou WebP de até 20MB. Fotos muito grandes exigem mais memória, então em dispositivos simples pode ser mais rápido redimensioná-las antes.',
    'faq_q9'  => 'Por que parte do meu objeto sumiu?',
    'faq_a9'  => 'Isso costuma acontecer quando o objeto tem cor parecida com a do fundo ou está parcialmente fora de foco. Tente uma foto com melhor iluminação e mais contraste e execute a ferramenta novamente.',
    'faq_q10' => 'Preciso instalar alguma coisa?',
    'faq_a10' => 'Não. Não há nada para baixar ou instalar. Abra a página, escolha uma imagem e baixe o PNG transparente. O modelo de IA fica em cache no navegador após o primeiro uso.',

    // About
    'about_title' => 'Sobre o RemoveBG',
    'about_p1' => 'O RemoveBG foi criado para tornar a remoção de fundo com qualidade profissional acessível a todos, sem assinaturas, limites ocultos ou concessões de privacidade. Acreditamos que uma tarefa usada todos os dias por vendedores, estudantes, designers e criadores deve ser simples, rápida e gratuita.',
    'about_p2' => 'Em vez de enviar suas imagens para um servidor remoto, o site entrega um modelo de IA compacto ao seu navegador e deixa o seu próprio dispositivo fazer o trabalho. Essa abordagem mantém seus arquivos privados, elimina o tempo de envio e nos permite manter o serviço gratuito para todos.',
    'about_p3' => 'Continuamos melhorando a interface, a documentação e os idiomas suportados. Se você tem uma sugestão ou encontrou um problema, seu feedback nos ajuda a melhorar a ferramenta para toda a comunidade.',
];
