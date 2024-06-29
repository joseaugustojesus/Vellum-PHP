<?= $this->layout("templates/base", [
    "title_in_card" => "Cadastrar Livro"
]) ?>



<form action="<?= route("/books/store") ?>" method="POST">
    <div class="row g-3">

        <!-- Fields -->
        <div class="col-12 col-md-4">
            <label for="author" class="form-label fw-bold">Autor <span>*</span></label>
            <input id="author" name="author" type="text" class="form-control" placeholder="Example: George Orwell" value="teste">
        </div>

        <div class="col-12 col-md-3">
            <label for="publishedAt" class="form-label fw-bold">Publicação <span>*</span></label>
            <input id="publishedAt" name="published_at" type="date" class="form-control" value="<?= date("Y-m-d"); ?>" >
        </div>

        <div class="col-12 col-md-5">
            <label for="name" class="form-label fw-bold">Livro <span>*</span></label>
            <input id="name" name="name" type="text" class="form-control" placeholder="Example: A Revolução Dos Bichos" value="teste">
        </div>

        <!-- submit -->
        <div class="col-12">
            <button type="submit" class="btn btn-company float-end">Salvar Livro</button>
        </div>
    </div>
</form>