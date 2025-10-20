<div class="container mx-auto p-5">
    <form action="addCreature" method="POST">
        <div class="mb-3">
            <label for="prompt" class="form-label">Nombre de têtes</label>
            <input type="text" class="form-control" id="heads" name="heads" required>
        </div>
        <div class="mb-3">
            <label for="prompt" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer la créature</button>
    </form>
</div>