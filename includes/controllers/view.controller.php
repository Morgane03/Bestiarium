<?php

function renderPage(string $pageName, array $datas = []): void
{

    // Sécurise le nom de la page
    $safePage = basename($pageName);

    // Chemin absolu vers le fichier de vue
    $viewFile = 'C:\\wamp64\\www\\MyDigitalSchool\\Bestiarium\\includes\\views\\' . $safePage . '.php';

    if (file_exists($viewFile)) {
        // Inclure layout.php en lui donnant accès à $viewFile
        $params = $datas;
        require 'C:\\wamp64\\www\\MyDigitalSchool\\Bestiarium\\includes\\views\\layout.php';
    } else {
        http_response_code(404);
        echo "Page not found.";
    }
}