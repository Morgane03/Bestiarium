window.onload = function() {
    // Configure Swagger UI
    const ui = SwaggerUIBundle({
        url: "../openapi.yaml", // <-- ton fichier YAML ici
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout"
    })

    window.ui = ui
}
