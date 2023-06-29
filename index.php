<?php
$filepath = 'C:/fakepath/urls.txt';
$archive = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($archive !== false) {
    $urls = array_chunk($archive, 80); // Divide as URLs em lotes de 80 linhas
    foreach ($urls as $urlBatch) {
        $baseUrl = 'https://fakeurl.com/storage/';
        $downloadPath = 'D:/fakepath/noticias_imagens/';

        $filenames = array();
        $duplicates = array();

        foreach ($urlBatch as $url) {
            $fullUrl = $baseUrl . $url;
            $filename = basename($url);
            if (in_array($filename, $filenames)) {
                $duplicates[] = $filename;
            } else {
                $filenames[] = $filename;
                $filepath = $downloadPath . $filename;
                $imageData = file_get_contents($fullUrl);
                file_put_contents($filepath, $imageData);

                echo "Imagem '$filename' baixada com sucesso!<br>";
            }
        }

        if (!empty($duplicates)) {
            echo "Nomes de arquivo repetidos encontrados:<br>";
            foreach ($duplicates as $duplicate) {
                echo $duplicate . "<br>";
            }
        } else {
            echo "Nenhum nome de arquivo repetido encontrado.";
        }
    }
}
