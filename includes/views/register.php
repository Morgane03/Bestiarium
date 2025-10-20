 <div id="form-container" class="container my-5">
  <h2 class="text-darkgreen border-bottom border-darkgreen mb-4">Créer un compte</h2>
  <form id="inscription-form"
        action="register"
        method="POST"
        class="text-end">
    <div class="d-flex mb-3">
      <div class="form-group d-flex align-items-center flex-grow-1">
        <label for="pseudo" class="text-nowrap input-group-text border-end-0 rounded-end-0 dinproMedium">
          Pseudo <sup class="dinproMedium text-red">*</sup></label>
        <input type="text" class="form-control rounded-start-0" id="pseudo" name="pseudo" required>
      </div>
    </div>

    <div class="d-flex mb-3">
      <div class="form-group d-flex align-items-center flex-grow-1">
        <label for="email" class="text-nowrap input-group-text border-end-0 rounded-end-0 dinproMedium">
          Email <sup class="dinproMedium text-red">*</sup></label>
        <input type="email" class="form-control rounded-start-0" id="email" name="email" required>
      </div>
    </div>

    <div class="d-flex mb-3">
      <div class="form-group d-flex align-items-center flex-grow-1">
        <label for="password" class="text-nowrap input-group-text border-end-0 rounded-end-0 dinproMedium">
          Mot de passe <sup class="dinproMedium text-red">*</sup></label>
        <input type="password" class="form-control rounded-start-0" id="password" name="password" placeholder="Créer un mot de passe" required>
      </div>
    </div>

    <a href="showLogin" class="btn btn-secondary mt-4">Retour</a>

    <input type="submit" name="Submit" value="S'inscrire" class="btn btn-secondary mt-4">
  </form>
</div>
