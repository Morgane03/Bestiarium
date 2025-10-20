<div class="container mx-auto p-5">
    <div class="container my-5">
        <div class="container mx-auto p-5">
            <div class="text-center mb-5">
                <h1 class="fw-bold">L'Académie du Bestiarium vous accueille</h1>
                <h3>Depuis des siècles, l'Académie du Bestiarium forme les plus
                    grands créateurs de créatures mythologiques</h3>
                <p>Aujourd'hui, vous faites partie d'une nouvelle génération d'apprentis mages s'apprêtant
                    à relever un défi sans précédent : être capable d'invoquer, de décrire et de faire
                    combattre des créatures légendaires. Vous deviendrez des Archimages, maîtrisant
                    l'art ancestral de donner vie à des êtres fantastiques par la seule force de vos
                    incantations</p>
            </div>
        </div>
    </div>
    <div class="text-center mb-5">
        <h1 class="fw-bold">Connexion</h1>

        <!-- Formulaire de connexion -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="p-4 p-md-5 border rounded-3 bg-light shadow-sm" action="login"
                    method="POST">
                    <!-- Champ Pseudo -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput"
                            placeholder="Entrez votre identifiant" name="pseudo" required>
                        <label for="floatingInput">Entrer votre identifiant</label>
                    </div>

                    <!-- Champ Mot de Passe -->
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Secret</span>
                        <input type="password" class="form-control" placeholder="Votre mot de passe"
                            aria-label="Votre mot de passe" aria-describedby="basic-addon1" name="password"
                            id="password">
                    </div>

                    <!-- Bouton de connexion -->
                    <button class="button btn-more bg-darkgreen bg-red-hover" type="submit">Se connecter</button>
                </form>

                <!-- Lien vers la création de compte -->
                <div class="d-flex justify-content-center align-items-center text-center mt-4">
                    <p class="fs-6 text-muted mb-0">Pas encore inscrit ?</p>
                    <a href="showRegister" class="btn btn-outline-secondary ms-2">Créez votre compte ici</a>
                </div>
            </div>
        </div>
    </div>
</div>